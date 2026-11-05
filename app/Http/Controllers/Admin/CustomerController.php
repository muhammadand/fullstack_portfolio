<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /** Kolom yang tampil di UI; password tidak pernah dimuat, cukup flag has_account. */
    private const LIST_COLUMNS = ['id', 'name', 'email', 'phone', 'source', 'points', 'created_at'];

    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $source = $request->query('source');

        $query = Customer::select(self::LIST_COLUMNS)
            ->selectRaw('(password is not null) as has_account')
            ->withCount(['orders', 'bookings'])
            ->withSum(['orders as total_spent' => fn ($q) => $q->where('payment_status', 'paid')], 'total_amount')
            ->latest();

        if (is_string($source) && array_key_exists($source, Customer::SOURCE_META)) {
            $query->where('source', $source);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $like = "%{$search}%";
                $q->where('name', 'like', $like)->orWhere('email', 'like', $like)->orWhere('phone', 'like', $like);
            });
        }

        $customers = $query->paginate(15)->withQueryString();

        $stats = Customer::selectRaw('
            count(*) as total,
            coalesce(sum(source = ?), 0) as topup,
            coalesce(sum(source = ?), 0) as travel,
            coalesce(sum(source = ?), 0) as google_card
        ', [Customer::SOURCE_TOPUP, Customer::SOURCE_TRAVEL, Customer::SOURCE_GOOGLE_CARD])->first();

        return view('admin.customers.index', compact('customers', 'stats', 'search', 'source'));
    }

    public function show(Customer $customer)
    {
        $customer->loadCount(['orders', 'bookings'])
            ->loadSum(['orders as total_spent' => fn ($q) => $q->where('payment_status', 'paid')], 'total_amount');

        $orders = $customer->orders()
            ->select(['id', 'customer_id', 'order_no', 'product_name', 'total_amount', 'status', 'payment_status', 'created_at'])
            ->latest()->limit(10)->get();

        return view('admin.customers.show', compact('customer', 'orders'));
    }
}
