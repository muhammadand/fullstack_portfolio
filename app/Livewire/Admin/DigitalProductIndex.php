<?php

namespace App\Livewire\Admin;

use App\Models\DigitalProduct;
use App\Models\DigitalProductBrand;
use App\Models\DigitalProductSyncLog;
use App\Models\PriceLevel;
use App\Services\DigitalProductSyncService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class DigitalProductIndex extends Component
{
    use WithPagination;

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

    public function mount(): void
    {
        if (!in_array($this->provider, ['digiflazz', 'lynk'], true)) {
            $this->provider = 'digiflazz';
        }
    }

    public function updated(string $property): void
    {
        if (in_array($property, ['provider', 'search', 'category', 'brand', 'status'], true)) {
            $this->resetPage();
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

        $log = $service->sync(auth()->id());

        if ($log->status === 'failed') {
            $this->error = 'Sinkronisasi gagal: ' . $log->error_message;

            return;
        }

        $this->notice = sprintf(
            'Sinkronisasi selesai: %d produk diterima, %d baru, %d diperbarui, %d perubahan modal, %d hilang dari katalog.',
            $log->total_received, $log->total_new, $log->total_updated, $log->total_cost_changed, $log->total_missing
        );
        $this->resetPage();
    }

    public function toggle(int $id): void
    {
        $product = DigitalProduct::digiflazz()->select('id', 'name', 'is_active')->findOrFail($id);
        $product->update(['is_active' => !$product->is_active]);

        $this->reset('error');
        $this->notice = sprintf('Produk %s %s.', $product->name, $product->is_active ? 'diaktifkan' : 'dinonaktifkan');
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

    #[Computed]
    public function categories()
    {
        return DigitalProduct::where('provider', $this->provider)
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
    }

    #[Computed]
    public function brands()
    {
        return DigitalProductBrand::orderBy('category')->orderBy('name')->get(['id', 'name', 'category']);
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
                'id', 'name', 'sku_code', 'category', 'type', 'digital_product_brand_id', 'cost_price',
                'buyer_product_status', 'seller_product_status', 'start_cut_off', 'end_cut_off',
                'is_active', 'is_missing',
            ])->with([
                'brand:id,name',
                'priceOverrides:id,digital_product_id,price_level_id,selling_price',
            ])->orderBy('category')->orderBy('name');
        } else {
            $query->select([
                'id', 'name', 'short_description', 'thumbnail', 'category', 'lynk_slug', 'price', 'demo_url', 'is_active',
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
            $query->where('category', $this->category);
        }

        if ($isDigiflazz) {
            if ($this->brand !== '') {
                $query->where('digital_product_brand_id', $this->brand);
            }

            match ($this->status) {
                'active' => $query->where('is_active', true),
                'inactive' => $query->where('is_active', false),
                'missing' => $query->where('is_missing', true),
                'unavailable' => $query->where(fn ($q) => $q->where('buyer_product_status', false)->orWhere('seller_product_status', false)),
                default => null,
            };
        }

        return view('livewire.admin.digital-product-index', [
            'products' => $query->paginate($isDigiflazz ? 25 : 10),
            'isDigiflazz' => $isDigiflazz,
        ]);
    }
}
