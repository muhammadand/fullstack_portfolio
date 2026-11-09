<?php

namespace App\Http\Controllers\Affiliate;

use App\Exceptions\PartnerOrderException;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Services\PartnerOrderService;
use App\Services\PpobCatalogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Produk digital partner (pulsa, paket data): daftar harga level partner, checkout dengan saldo wallet, status order.
 * Semua jenis memakai alur yang sama; bedanya hanya kategori Digiflazz (config/ppob.php) dan source order.
 */
class PpobController extends Controller
{
    /** type => [label, source order, route halaman, route order, ikon] */
    public const TYPES = [
        'pulsa' => [
            'label' => 'Pulsa', 'source' => Order::SOURCE_PULSA,
            'route' => 'affiliate.ppob.pulsa', 'order_route' => 'affiliate.ppob.pulsa.order', 'icon' => 'fa-mobile-screen-button',
        ],
        'paket_data' => [
            'label' => 'Paket Data', 'source' => Order::SOURCE_PAKET_DATA,
            'route' => 'affiliate.ppob.paket_data', 'order_route' => 'affiliate.ppob.paket_data.order', 'icon' => 'fa-wifi',
        ],
        'pln' => [
            'label' => 'Token PLN', 'source' => Order::SOURCE_PLN,
            'route' => 'affiliate.ppob.pln', 'order_route' => 'affiliate.ppob.pln.order', 'icon' => 'fa-bolt',
            // Nomor meter, bukan nomor HP: tanpa deteksi operator & tanpa normalisasi 08xx.
            'input_label' => 'Nomor Meter / ID Pelanggan', 'input_placeholder' => 'Contoh: 32123456789', 'phone' => false,
        ],
        // Top up game punya halaman sendiri (pilih game -> isi ID akun), checkout tetap lewat PartnerOrderService.
        'game' => [
            'label' => 'Top Up Game', 'source' => Order::SOURCE_TOPUP_GAME,
            'route' => 'affiliate.ppob.games', 'order_route' => null, 'icon' => 'fa-gamepad',
        ],
    ];

    /** Default untuk jenis yang memakai nomor HP. */
    private const PHONE_DEFAULTS = ['input_label' => 'Nomor HP tujuan', 'input_placeholder' => '08xxxxxxxxxx', 'phone' => true];

    /** Konfigurasi lengkap satu jenis produk. */
    public static function type(string $type): array
    {
        return self::TYPES[$type] + self::PHONE_DEFAULTS + ['type' => $type];
    }

    public function pulsa()
    {
        return $this->catalogPage('pulsa');
    }

    public function paketData()
    {
        return $this->catalogPage('paket_data');
    }

    public function orderPulsa(Request $request, PartnerOrderService $orders)
    {
        return $this->placeOrder($request, $orders, 'pulsa');
    }

    public function orderPaketData(Request $request, PartnerOrderService $orders)
    {
        return $this->placeOrder($request, $orders, 'paket_data');
    }

    public function pln()
    {
        return $this->catalogPage('pln');
    }

    public function orderPln(Request $request, PartnerOrderService $orders)
    {
        return $this->placeOrder($request, $orders, 'pln');
    }

    /** Daftar game (brand kategori "games" yang punya produk dijual). */
    public function games()
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        if ($affiliate->status === 'pending') {
            return redirect()->route('affiliate.dashboard');
        }

        return view('affiliate.ppob.games', [
            'affiliate' => $affiliate,
            'catalog' => \App\Services\TopupCatalogService::games(),
            'walletBalance' => (float) $affiliate->getOrCreateWallet()->balance,
        ]);
    }

    /** Detail satu game: form ID akun + nominal dengan harga partner. */
    public function game(string $slug)
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        if ($affiliate->status === 'pending') {
            return redirect()->route('affiliate.dashboard');
        }

        $game = PpobCatalogService::game($slug, $affiliate);
        abort_if($game === null, 404);

        return view('affiliate.ppob.game', [
            'affiliate' => $affiliate,
            'game' => $game,
            'walletBalance' => (float) $affiliate->getOrCreateWallet()->balance,
            'idempotencyKey' => (string) Str::uuid(),
        ]);
    }

    public function orderGame(Request $request, PartnerOrderService $orders, string $slug)
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        if ($affiliate->status !== 'approved') {
            return redirect()->route('affiliate.dashboard');
        }

        $game = PpobCatalogService::game($slug, $affiliate);
        abort_if($game === null, 404);

        $fields = $game['form']['fields'];
        $rules = ['product_id' => ['required', 'integer'], 'idempotency_key' => ['required', 'string', 'uuid']];
        $labels = [];
        foreach ($fields as $f) {
            $rules['account.' . $f['key']] = ['required', 'string', 'regex:/' . str_replace('/', '\\/', $f['pattern']) . '/'];
            $labels['account.' . $f['key']] = $f['label'];
        }
        $data = $request->validate($rules, [], $labels);

        // Produk harus milik game ini (bukan produk lain yang id-nya ditebak).
        $item = collect($game['products'])->firstWhere('id', (int) $data['product_id']);
        $product = $item && $item['available'] ? \App\Models\DigitalProduct::sellable()->with('priceOverrides')->find($item['id']) : null;

        if (!$product) {
            return back()->withInput()->with('error', 'Nominal tidak tersedia, silakan pilih yang lain.');
        }

        $account = collect($fields)->mapWithKeys(fn ($f) => [$f['key'] => trim($data['account'][$f['key']])])->all();

        try {
            $order = $orders->checkout(
                $affiliate, $product, Order::SOURCE_TOPUP_GAME,
                $account ? implode('', $account) : '-', // format Digiflazz: semua ID akun digabung (mis. User ID + Zone ID)
                $data['idempotency_key'], $account
            );
        } catch (PartnerOrderException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('affiliate.ppob.orders.show', $order->order_no);
    }

    public function showOrder(string $orderNo)
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        // Hanya order milik partner ini (404 untuk order orang lain, tanpa membocorkan keberadaannya).
        $order = Order::where('order_no', $orderNo)
            ->where('affiliate_id', $affiliate->id)
            ->firstOrFail();

        $events = $order->events()
            ->whereIn('event', [
                OrderEvent::ORDER_CREATED,
                OrderEvent::WALLET_DEBITED,
                OrderEvent::PROVIDER_SENT,
                OrderEvent::PROVIDER_RESULT,
                OrderEvent::WALLET_REFUNDED,
            ])
            ->get(['id', 'event', 'status_to', 'amount', 'created_at']);

        $ppob = self::typeForSource($order->source);

        return view('affiliate.ppob.order_status', compact('affiliate', 'order', 'events', 'ppob'));
    }

    /** Konfigurasi jenis produk untuk source order (fallback: pulsa). */
    public static function typeForSource(?string $source): array
    {
        foreach (self::TYPES as $type => $cfg) {
            if ($cfg['source'] === $source) {
                return self::type($type);
            }
        }

        return self::type('pulsa');
    }

    private function catalogPage(string $type)
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        if ($affiliate->status === 'pending') {
            return redirect()->route('affiliate.dashboard');
        }

        $catalog = PpobCatalogService::catalog($type, $affiliate);

        return view('affiliate.ppob.pulsa', [
            'affiliate' => $affiliate,
            'ppob' => self::type($type),
            'level' => $catalog['level'],
            'operators' => $catalog['operators'],
            'walletBalance' => (float) $affiliate->getOrCreateWallet()->balance,
            // Kunci idempoten baru per kunjungan halaman: submit ganda dari form yang sama = satu order.
            'idempotencyKey' => (string) Str::uuid(),
        ]);
    }

    private function placeOrder(Request $request, PartnerOrderService $orders, string $type)
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        if ($affiliate->status !== 'approved') {
            return redirect()->route('affiliate.dashboard');
        }

        // Nomor HP dinormalkan ke 08xx; nomor meter PLN cukup diambil digitnya saja.
        $raw = (string) $request->input('customer_no');
        $request->merge(['customer_no' => self::type($type)['phone'] ? self::normalizePhone($raw) : preg_replace('/\D/', '', $raw)]);

        $data = $request->validate([
            'product_id' => ['required', 'integer'],
            // Validasi format nomor dimatikan sementara untuk testing (aktifkan lagi: 'regex:/^08\d{8,11}$/').
            'customer_no' => ['required', 'string', 'max:30'],
            'idempotency_key' => ['required', 'string', 'uuid'],
        ], [
            'customer_no.required' => self::type($type)['input_label'] . ' wajib diisi.',
        ]);

        $product = PpobCatalogService::findProduct($type, (int) $data['product_id']);

        if (!$product) {
            return back()->withInput()->with('error', 'Produk tidak ditemukan atau sedang tidak dijual.');
        }

        try {
            $order = $orders->checkout($affiliate, $product, self::TYPES[$type]['source'], $data['customer_no'], $data['idempotency_key']);
        } catch (PartnerOrderException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('affiliate.ppob.orders.show', $order->order_no);
    }

    /** "+62 812-3456-7890" / "812..." -> "0812..." */
    public static function normalizePhone(string $value): string
    {
        $digits = preg_replace('/\D/', '', $value);

        if (str_starts_with($digits, '62')) {
            $digits = '0' . substr($digits, 2);
        } elseif (str_starts_with($digits, '8')) {
            $digits = '0' . $digits;
        }

        return $digits;
    }
}
