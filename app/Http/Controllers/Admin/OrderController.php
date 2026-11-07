<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderEvent;
use Illuminate\Http\Request;

/**
 * Order produk digital untuk admin. Satu halaman untuk semua jenis order;
 * kolom `source` (top up game, pulsa, paket data, PLN) jadi tab di daftar.
 */
class OrderController extends Controller
{
    public function index(Request $request)
    {
        $source = $request->query('source');
        $source = array_key_exists((string) $source, Order::SOURCES) ? $source : null; // null = tab "Semua"
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status');
        $payment = $request->query('payment_status');
        $date = $request->query('date');

        // Hanya kolom yang tampil di daftar (hindari account_data, qris_image_url, provider_message, dll).
        $query = Order::select([
            'id', 'order_no', 'source', 'customer_id', 'affiliate_id', 'product_name', 'customer_no', 'email',
            'total_amount', 'status', 'payment_status', 'created_at',
        ])->with(['customer:id,name', 'affiliate:id,name'])->latest();

        if ($source) {
            $query->where('source', $source);
        }

        if (in_array($status, Order::STATUSES, true)) {
            $query->where('status', $status);
        }

        if (in_array($payment, Order::PAYMENT_STATUSES, true)) {
            $query->where('payment_status', $payment);
        }

        if ($date) {
            $query->whereDate('created_at', $date);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $like = "%{$search}%";
                $q->where('order_no', 'like', $like)
                    ->orWhere('customer_no', 'like', $like)
                    ->orWhere('email', 'like', $like)
                    ->orWhere('product_name', 'like', $like)
                    ->orWhereHas('customer', fn ($c) => $c->where('name', 'like', $like)->orWhere('phone', 'like', $like))
                    ->orWhereHas('affiliate', fn ($a) => $a->where('name', 'like', $like));
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        // Ringkasan mengikuti tab yang aktif.
        $stats = Order::when($source, fn ($q) => $q->where('source', $source))->selectRaw("
            count(*) as total,
            coalesce(sum(payment_status = 'unpaid'), 0) as unpaid,
            coalesce(sum(status = 'processing'), 0) as processing,
            coalesce(sum(case when payment_status = 'paid' then total_amount end), 0) as revenue
        ")->first();

        // Jumlah order per source untuk label tab (satu query).
        $sourceCounts = Order::selectRaw('source, count(*) as total')->groupBy('source')->pluck('total', 'source');
        $tabs = collect(Order::SOURCES)->map(fn ($meta, $key) => [
            'key' => $key,
            'label' => $meta[0],
            'count' => (int) ($sourceCounts[$key] ?? 0),
        ])->values()->prepend(['key' => null, 'label' => 'Semua', 'count' => (int) $sourceCounts->sum()]);

        return view('admin.orders.index', compact('orders', 'stats', 'tabs', 'source', 'search', 'status', 'payment', 'date'));
    }

    public function show(Order $order)
    {
        $order->load('customer', 'affiliate:id,name,email,affiliate_code', 'digitalProduct.brand');

        // Jejak audit (order_events) untuk order wallet partner; order top up lama belum punya.
        $events = $order->events()->get();
        $chainValid = $events->isEmpty() ? null : OrderEvent::verifyChain($order->id);

        return view('admin.orders.show', compact('order', 'events', 'chainValid'));
    }
}
