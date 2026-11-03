<?php

namespace App\Livewire\Admin;

use App\Models\Affiliate;
use App\Models\DigitalProduct;
use App\Models\DigitalProductBrand;
use App\Models\DigitalProductCategory;
use App\Models\DigitalProductCostHistory;
use App\Models\DigitalProductSyncLog;
use App\Models\PriceLevel;
use App\Services\DigitalProductSyncService;
use App\Services\TopupCatalogService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DigitalProductIndex extends Component
{
    use WithPagination, WithFileUploads;

    /** digiflazz | lynk */
    #[Url(as: 'provider')]
    public string $provider = 'digiflazz';

    #[Url(as: 'q')]
    public string $search = '';

    #[Url]
    public string $category = '';

    #[Url]
    public string $brand = '';

    #[Url]
    public string $status = '';

    public ?string $notice = null;
    public ?string $error = null;

    // Modal detail & edit (id produk yang sedang dibuka)
    public ?int $detailId = null;
    public ?int $editId = null;

    // Form edit: hanya kolom milik kita, bukan data supplier (ditimpa tiap sync)
    public bool $editIsActive = false;
    public string $editDisplayOrder = '0';
    /** @var array<int|string, string> price_level_id => harga jual manual ('' = otomatis) */
    public array $editPrices = [];

    // Modal pengaturan harga (margin per level, data dari tabel price_levels)
    public bool $pricingOpen = false;
    /** @var array<int|string, array{name: string, margin_type: string, margin_value: string}> */
    public array $levelForms = [];

    // Modal gambar brand (tampil di landing page top up)
    public bool $brandImagesOpen = false;
    /** @var array<int|string, mixed> brand_id => file upload sementara */
    public array $brandUploads = [];

    public function mount(): void
    {
        if (!in_array($this->provider, ['digiflazz', 'lynk'], true)) {
            $this->provider = 'digiflazz';
        }
    }

    public function updated(string $property): void
    {
        if (str_starts_with($property, 'brandUploads.')) {
            $this->saveBrandImage((int) substr($property, strlen('brandUploads.')));

            return;
        }

        if (in_array($property, ['provider', 'search', 'category', 'brand', 'status'], true)) {
            $this->resetPage();
        }

        // Pilihan brand hanya valid untuk kategori yang sedang dipilih.
        if ($property === 'category') {
            $this->reset('brand');
        }

        if ($property === 'provider') {
            $this->reset('category', 'brand', 'status', 'notice', 'error');
        }
    }

    public function resetFilters(): void
    {
        $this->reset('search', 'category', 'brand', 'status');
        $this->resetPage();
    }

    public function sync(DigitalProductSyncService $service): void
    {
        $this->reset('notice', 'error');

        // Price-list Digiflazz bisa besar; beri ruang waktu lebih dari default PHP.
        set_time_limit(120);

        if (DigitalProductSyncLog::where('status', 'running')->where('started_at', '>', now()->subMinutes(5))->exists()) {
            $this->error = 'Sinkronisasi masih berjalan, coba lagi beberapa saat.';

            return;
        }

        $log = $service->sync(Auth::id());

        if ($log->status === 'failed') {
            $this->error = 'Sinkronisasi gagal: ' . $log->error_message;

            return;
        }

        $this->notice = sprintf(
            'Sinkronisasi selesai: %d produk diterima, %d baru, %d diperbarui, %d perubahan modal, %d hilang dari katalog.',
            $log->total_received,
            $log->total_new,
            $log->total_updated,
            $log->total_cost_changed,
            $log->total_missing
        );
        $this->resetPage();
    }

    public function toggle(int $id): void
    {
        $product = DigitalProduct::digiflazz()->select('id', 'name', 'is_active')->findOrFail($id);
        $product->update(['is_active' => !$product->is_active]);
        TopupCatalogService::flush();

        $this->reset('error');
        $this->notice = sprintf('Produk %s %s.', $product->name, $product->is_active ? 'diaktifkan' : 'dinonaktifkan');
    }

    public function openDetail(int $id): void
    {
        $this->reset('editId', 'pricingOpen');
        $this->detailId = DigitalProduct::digiflazz()->whereKey($id)->value('id');
    }

    public function openEdit(int $id): void
    {
        $this->reset('detailId', 'pricingOpen');
        $this->resetValidation();

        $product = DigitalProduct::digiflazz()
            ->with('priceOverrides:id,digital_product_id,price_level_id,selling_price')
            ->findOrFail($id, ['id', 'is_active', 'display_order']);

        $this->editId = $product->id;
        $this->editIsActive = $product->is_active;
        $this->editDisplayOrder = (string) $product->display_order;
        $this->editPrices = $this->levels->mapWithKeys(fn ($level) => [
            $level->id => (string) ($product->priceOverrides->firstWhere('price_level_id', $level->id)?->selling_price + 0 ?: ''),
        ])->all();
    }

    public function openPricing(): void
    {
        $this->reset('detailId', 'editId');
        $this->resetValidation();

        $this->levelForms = PriceLevel::orderBy('id')->get(['id', 'name', 'margin_type', 'margin_value'])
            ->mapWithKeys(fn ($level) => [$level->id => [
                'name' => $level->name,
                'margin_type' => $level->margin_type,
                'margin_value' => (string) ($level->margin_value + 0),
            ]])->all();
        $this->pricingOpen = true;
    }

    public function savePricing(): void
    {
        $this->validate([
            'levelForms.*.name' => ['required', 'string', 'max:100'],
            'levelForms.*.margin_type' => ['required', 'in:percent,fixed'],
            'levelForms.*.margin_value' => ['required', 'numeric', 'min:0', 'max:99999999'],
        ], [], [
            'levelForms.*.name' => 'nama level',
            'levelForms.*.margin_type' => 'jenis margin',
            'levelForms.*.margin_value' => 'nilai margin',
        ]);

        // Margin persen di atas 100% hampir pasti salah ketik.
        foreach ($this->levelForms as $id => $form) {
            if ($form['margin_type'] === 'percent' && (float) $form['margin_value'] > 100) {
                $this->addError("levelForms.{$id}.margin_value", 'Margin persen maksimal 100%.');
            }
        }

        if ($this->getErrorBag()->isNotEmpty()) {
            return;
        }

        DB::transaction(function () {
            foreach ($this->levelForms as $id => $form) {
                PriceLevel::whereKey($id)->update([
                    'name' => $form['name'],
                    'margin_type' => $form['margin_type'],
                    'margin_value' => $form['margin_value'],
                ]);
            }
        });

        unset($this->levels); // muat ulang agar harga di tabel langsung memakai margin baru
        $this->closeModal();
        $this->reset('error');
        $this->notice = 'Pengaturan harga berhasil disimpan. Harga jual otomatis mengikuti margin baru, kecuali produk dengan harga manual.';
    }

    public function openBrandImages(): void
    {
        $this->reset('detailId', 'editId', 'pricingOpen', 'brandUploads');
        $this->resetValidation();
        $this->brandImagesOpen = true;
    }

    protected function saveBrandImage(int $brandId): void
    {
        $file = $this->brandUploads[$brandId] ?? null;

        $this->validateOnly("brandUploads.$brandId", [
            "brandUploads.$brandId" => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [], ["brandUploads.$brandId" => 'gambar']);

        $brand = DigitalProductBrand::findOrFail($brandId, ['id', 'image']);
        $path = $file->store('topup/brands', 'public');

        if ($brand->image) {
            Storage::disk('public')->delete($brand->image);
        }

        $brand->update(['image' => $path]);
        unset($this->brandUploads[$brandId], $this->brandList);
        TopupCatalogService::flush();
    }

    public function removeBrandImage(int $brandId): void
    {
        $brand = DigitalProductBrand::findOrFail($brandId, ['id', 'image']);

        if ($brand->image) {
            Storage::disk('public')->delete($brand->image);
            $brand->update(['image' => null]);
        }

        unset($this->brandList);
        TopupCatalogService::flush();
    }

    /** Brand kategori Games untuk modal gambar brand. */
    #[Computed]
    public function brandList()
    {
        return DigitalProductBrand::whereHas('category', fn ($q) => $q->where('slug', TopupCatalogService::CATEGORY_SLUG))
            ->orderBy('display_order')->orderBy('name')
            ->get(['id', 'name', 'image']);
    }

    public function closeModal(): void
    {
        $this->reset('brandImagesOpen', 'brandUploads');
        $this->reset('detailId', 'editId', 'pricingOpen', 'levelForms');
        $this->resetValidation();
    }

    public function saveEdit(): void
    {
        $this->validate([
            'editDisplayOrder' => ['required', 'integer', 'min:0'],
            'editPrices.*' => ['nullable', 'numeric', 'min:0'],
        ], [], ['editDisplayOrder' => 'urutan tampil', 'editPrices.*' => 'harga jual']);

        $product = DigitalProduct::digiflazz()->findOrFail($this->editId, ['id', 'name', 'cost_price']);

        // Harga manual tidak boleh di bawah modal supaya tidak menjual rugi.
        foreach ($this->editPrices as $levelId => $price) {
            if ($price !== '' && (float) $price < (float) $product->cost_price) {
                $this->addError("editPrices.{$levelId}", 'Harga jual tidak boleh di bawah modal (Rp ' . number_format($product->cost_price, 0, ',', '.') . ').');
            }
        }

        if ($this->getErrorBag()->isNotEmpty()) {
            return;
        }

        DB::transaction(function () use ($product) {
            $product->update([
                'is_active' => $this->editIsActive,
                'display_order' => (int) $this->editDisplayOrder,
            ]);

            foreach ($this->editPrices as $levelId => $price) {
                if ($price === '') {
                    $product->priceOverrides()->where('price_level_id', $levelId)->delete();
                } else {
                    $product->priceOverrides()->updateOrCreate(
                        ['price_level_id' => $levelId],
                        ['selling_price' => $price]
                    );
                }
            }
        });

        TopupCatalogService::flush();
        $this->closeModal();
        $this->reset('error');
        $this->notice = "Produk {$product->name} berhasil diperbarui.";
    }

    public function deleteProduct(int $id): void
    {
        $product = DigitalProduct::digiflazz()->findOrFail($id, ['id', 'name']);
        $product->delete(); // override harga & riwayat modal ikut terhapus (cascade)
        TopupCatalogService::flush();

        $this->closeModal();
        $this->reset('error');
        $this->notice = "Produk {$product->name} dihapus. Produk akan muncul lagi (nonaktif) jika masih ada di price-list saat sync berikutnya.";
    }

    /**
     * Kosongkan seluruh data katalog Digiflazz: produk, override harga, riwayat modal,
     * riwayat sync, brand, dan kategori. Produk Lynk.id tidak disentuh.
     */
    public function clearAll(): void
    {
        $counts = DB::transaction(function () {
            $products = DigitalProduct::digiflazz()->delete(); // prices & cost_histories ikut terhapus (cascade)
            $logs = DigitalProductSyncLog::query()->delete();
            $brands = DigitalProductBrand::query()->delete();
            $categories = DigitalProductCategory::query()->delete();

            return compact('products', 'logs', 'brands', 'categories');
        });

        TopupCatalogService::flush();
        $this->reset('search', 'category', 'brand', 'status', 'detailId', 'editId', 'error');
        $this->resetPage();
        $this->notice = sprintf(
            'Semua data dibersihkan: %d produk, %d brand, %d kategori, dan %d riwayat sync.',
            $counts['products'], $counts['brands'], $counts['categories'], $counts['logs']
        );
    }

    #[Computed]
    public function detailProduct(): ?DigitalProduct
    {
        return $this->detailId
            ? DigitalProduct::with(['brand:id,name,digital_product_category_id', 'brand.category:id,name', 'priceOverrides'])->find($this->detailId)
            : null;
    }

    #[Computed]
    public function detailCostHistories()
    {
        return $this->detailId
            ? DigitalProductCostHistory::where('digital_product_id', $this->detailId)->latest('changed_at')->limit(10)->get(['id', 'old_cost', 'new_cost', 'changed_at'])
            : collect();
    }

    #[Computed]
    public function editProduct(): ?DigitalProduct
    {
        return $this->editId
            ? DigitalProduct::select('id', 'name', 'sku_code', 'cost_price')->find($this->editId)
            : null;
    }

    #[Computed]
    public function stats(): array
    {
        $row = DigitalProduct::digiflazz()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('COALESCE(SUM(is_active = 1), 0) as active')
            ->selectRaw('COALESCE(SUM(is_active = 0), 0) as inactive')
            ->selectRaw('COALESCE(SUM(is_missing = 1), 0) as missing')
            ->selectRaw('MAX(last_synced_at) as last_synced_at')
            ->first();

        return [
            'total' => (int) $row->total,
            'active' => (int) $row->active,
            'inactive' => (int) $row->inactive,
            'missing' => (int) $row->missing,
            'last_synced_at' => $row->last_synced_at ? \Illuminate\Support\Carbon::parse($row->last_synced_at) : null,
        ];
    }

    #[Computed]
    public function levels()
    {
        return PriceLevel::orderBy('id')->get(['id', 'code', 'name', 'margin_type', 'margin_value', 'is_default']);
    }

    /** Opsi filter kategori: id => nama (Digiflazz) atau nama => nama (Lynk, masih string). */
    /** Jumlah partner (affiliate) per level, untuk info di modal pengaturan harga. */
    #[Computed]
    public function levelUsage(): array
    {
        return Affiliate::whereNotNull('price_level_id')
            ->selectRaw('price_level_id, COUNT(*) as total')
            ->groupBy('price_level_id')
            ->pluck('total', 'price_level_id')
            ->all();
    }

    #[Computed]
    public function categories(): array
    {
        if ($this->provider === 'digiflazz') {
            return DigitalProductCategory::orderBy('name')->pluck('name', 'id')->all();
        }

        return DigitalProduct::lynk()->whereNotNull('category')->distinct()->orderBy('category')->pluck('category', 'category')->all();
    }

    #[Computed]
    public function brands(): array
    {
        return DigitalProductBrand::with('category:id,name')
            ->when($this->category !== '', fn ($q) => $q->where('digital_product_category_id', $this->category))
            ->orderBy('name')
            ->get(['id', 'name', 'digital_product_category_id'])
            ->mapWithKeys(fn ($b) => [$b->id => $b->name . ' (' . $b->category?->name . ')'])
            ->all();
    }

    #[Computed]
    public function syncLogs()
    {
        return DigitalProductSyncLog::with('user:id,name')
            ->latest('id')
            ->limit(5)
            ->get(['id', 'status', 'total_received', 'total_new', 'total_updated', 'total_cost_changed', 'total_missing', 'error_message', 'triggered_by', 'started_at']);
    }

    public function render()
    {
        $isDigiflazz = $this->provider === 'digiflazz';
        $search = trim($this->search);

        $query = DigitalProduct::where('provider', $this->provider);

        if ($isDigiflazz) {
            $query->select([
                'id',
                'name',
                'sku_code',
                'type',
                'digital_product_brand_id',
                'cost_price',
                'buyer_product_status',
                'seller_product_status',
                'start_cut_off',
                'end_cut_off',
                'is_active',
                'is_missing',
            ])->with([
                'brand:id,name,digital_product_category_id',
                'brand.category:id,name',
                'priceOverrides:id,digital_product_id,price_level_id,selling_price',
            ])->orderBy('digital_product_brand_id')->orderBy('name');
        } else {
            $query->select([
                'id',
                'name',
                'short_description',
                'thumbnail',
                'category',
                'lynk_slug',
                'price',
                'demo_url',
                'is_active',
            ])->orderBy('display_order')->latest();
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search, $isDigiflazz) {
                $q->where('name', 'like', "%{$search}%");
                $isDigiflazz
                    ? $q->orWhere('sku_code', 'like', "%{$search}%")
                    : $q->orWhere('category', 'like', "%{$search}%")->orWhere('lynk_slug', 'like', "%{$search}%");
            });
        }

        if ($this->category !== '') {
            $isDigiflazz
                ? $query->whereHas('brand', fn ($q) => $q->where('digital_product_category_id', $this->category))
                : $query->where('category', $this->category);
        }

        if ($isDigiflazz) {
            if ($this->brand !== '') {
                $query->where('digital_product_brand_id', $this->brand);
            }

            match ($this->status) {
                'active' => $query->where('is_active', true),
                'inactive' => $query->where('is_active', false),
                'missing' => $query->where('is_missing', true),
                'unavailable' => $query->where(fn($q) => $q->where('buyer_product_status', false)->orWhere('seller_product_status', false)),
                default => null,
            };
        }

        $perPage = $isDigiflazz ? 25 : 10;
        $products = $query->paginate($perPage);

        // Setelah hapus item terakhir di halaman terakhir, mundur ke halaman yang masih ada isinya.
        if ($products->isEmpty() && $products->currentPage() > 1) {
            $this->setPage($products->lastPage());
            $products = $query->paginate($perPage);
        }

        return view('livewire.admin.digital-product-index', [
            'products' => $products,
            'isDigiflazz' => $isDigiflazz,
        ]);
    }
}
