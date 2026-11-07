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
 * PPOB partner: daftar harga level partner, checkout dengan saldo wallet, dan status order.
 */
class PpobController extends Controller
{
    public function pulsa()
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        if ($affiliate->status === 'pending') {
            return redirect()->route('affiliate.dashboard');
        }

        $catalog = PpobCatalogService::catalog('pulsa', $affiliate);

        return view('affiliate.ppob.pulsa', [
            'affiliate' => $affiliate,
            'level' => $catalog['level'],
            'operators' => $catalog['operators'],
            'walletBalance' => (float) $affiliate->getOrCreateWallet()->balance,
            // Kunci idempoten baru per kunjungan halaman: submit ganda dari form yang sama = satu order.
            'idempotencyKey' => (string) Str::uuid(),
        ]);
    }

    public function orderPulsa(Request $request, PartnerOrderService $orders)
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        if ($affiliate->status !== 'approved') {
            return redirect()->route('affiliate.dashboard');
        }

        $request->merge(['customer_no' => self::normalizePhone((string) $request->input('customer_no'))]);

        $data = $request->validate([
            'product_id' => ['required', 'integer'],
            // Validasi format nomor dimatikan sementara untuk testing (aktifkan lagi: 'regex:/^08\d{8,11}$/').
            'customer_no' => ['required', 'string', 'max:30'],
            'idempotency_key' => ['required', 'string', 'uuid'],
        ], [
            'customer_no.required' => 'Nomor HP tujuan wajib diisi.',
        ]);

        $product = PpobCatalogService::findProduct('pulsa', (int) $data['product_id']);

        if (!$product) {
            return back()->withInput()->with('error', 'Produk tidak ditemukan atau sedang tidak dijual.');
        }

        try {
            $order = $orders->checkout($affiliate, $product, Order::SOURCE_PULSA, $data['customer_no'], $data['idempotency_key']);
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

        return view('affiliate.ppob.order_status', compact('affiliate', 'order', 'events'));
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
