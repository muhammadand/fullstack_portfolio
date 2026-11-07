<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TopupOrderController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status');
        $payment = $request->query('payment_status');
        $date = $request->query('date');

        // Hanya kolom yang tampil di daftar (hindari account_data, qris_image_url, provider_message, dll).
        $query = Order::select([
            'id', 'order_no', 'customer_id', 'product_name', 'customer_no', 'email',
            'total_amount', 'status', 'payment_status', 'created_at',
        ])->with('customer:id,name')->latest();

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
                    ->orWhereHas('customer', fn ($c) => $c->where('name', 'like', $like)->orWhere('phone', 'like', $like));
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        $stats = Order::selectRaw("
            count(*) as total,
            coalesce(sum(payment_status = 'unpaid'), 0) as unpaid,
            coalesce(sum(status = 'processing'), 0) as processing,
            coalesce(sum(case when payment_status = 'paid' then total_amount end), 0) as revenue
        ")->first();

        return view('admin.topup_orders.index', compact('orders', 'stats', 'search', 'status', 'payment', 'date'));
    }

    public function show(Order $order)
    {
        $order->load('customer', 'digitalProduct.brand');

        return view('admin.topup_orders.show', compact('order'));
    }
}
