<?php

namespace App\Support;

use App\Models\Affiliate;
use App\Models\CustomerWithdrawal;
use App\Models\Order;
use App\Models\Withdrawal;

/**
 * Daftar menu admin. Dipakai sidebar desktop, bottom nav HP, dan halaman Menu HP (admin.menu).
 */
class AdminMenu
{
    public static function items(): array
    {
        return [
[
'label' => 'Dashboard',
'route' => 'dashboard.admin',
'icon' => 'fa-solid fa-gauge-high',
],
[
'label' => 'Category Portfolio',
'route' => 'portfolio-categories.index',
'icon' => 'fa-solid fa-layer-group',
],
[
'label' => 'Management Portfolio',
'route' => 'portfolio.index',
'icon' => 'fa-solid fa-briefcase',
],
[
'label' => 'Category Blogs',
'route' => 'blog-categories.index',
'icon' => 'fa-solid fa-tags',
],
[
'label' => 'Blogs',
'route' => 'blogs.index',
'icon' => 'fa-solid fa-pen-nib',
],
[
'label' => 'Documentation',
'route' => 'documentation.index',
'icon' => 'fa-solid fa-book',
],
[
'label' => 'Careers',
'route' => 'careers.index',
'icon' => 'fa-solid fa-briefcase',
],
[
'label' => 'Career Applications',
'route' => 'career-applications.index',
'icon' => 'fa-solid fa-file-lines',
],
[
'label' => 'Affiliate Partners',
'route' => 'admin.affiliates.index',
'icon' => 'fa-solid fa-handshake',
],
[
'label' => 'Withdrawals',
'route' => 'admin.withdrawals.index',
'icon' => 'fa-solid fa-money-bill-transfer',
],
[
'label' => 'Digiflazz',
'icon' => 'fa-solid fa-bolt',
'submenu' => [
[
'label' => 'Produk Digital',
'route' => 'admin.digital_products.index',
'icon' => 'fa-solid fa-cubes-stacked',
],
[
'label' => 'Order',
'route' => 'admin.orders.index',
'icon' => 'fa-solid fa-receipt',
],
[
'label' => 'Cek Saldo & Akun',
'route' => 'admin.ppob.index',
'icon' => 'fa-solid fa-wallet',
],
[
'label' => 'Penarikan Customer',
'route' => 'admin.customer_withdrawals.index',
'icon' => 'fa-solid fa-money-bill-transfer',
],
],
],
[
'label' => 'Customers',
'route' => 'admin.customers.index',
'icon' => 'fa-solid fa-user-group',
],
[
'label' => 'CV Service',
'route' => 'admin.cv_service.index',
'icon' => 'fa-solid fa-id-card',
],
[
'label' => 'Review Cards',
'icon' => 'fa-solid fa-qrcode',
'submenu' => [
[
'label' => 'Daftar Kartu QR',
'route' => 'admin.review_cards.index',
'icon' => 'fa-solid fa-id-card-clip',
],
[
'label' => 'Analitik Trafik',
'route' => 'admin.review_cards.analytics',
'icon' => 'fa-solid fa-chart-line',
],
],
],
[
'label' => 'Travel & Shuttle',
'logo' => 'images/travel/rivian_logo.jpg',
'submenu' => [
[
'label' => 'Pesanan Travel',
'route' => 'admin.travel_bookings.index',
'icon' => 'fa-solid fa-ticket',
],
[
'label' => 'Rute Perjalanan',
'route' => 'admin.travel_routes.index',
'icon' => 'fa-solid fa-map-location-dot',
],
[
'label' => 'Jadwal & Kuota',
'route' => 'admin.travel_schedules.index',
'icon' => 'fa-solid fa-calendar-days',
],
]
],
[
'label' => 'Marketing',
'icon' => 'fa-solid fa-bullhorn',
'submenu' => [
[
'label' => 'Client Proposals',
'route' => 'admin.client_proposals.index',
'icon' => 'fa-solid fa-file-invoice-dollar',
],
[
'label' => 'Template Chat',
'route' => 'admin.chat_templates.index',
'icon' => 'fa-solid fa-comment-dots',
],
[
'label' => 'Business Categories',
'route' => 'admin.business_categories.index',
'icon' => 'fa-solid fa-layer-group',
],
]
],
[
'label' => 'Users',
'route' => 'users.index',
'icon' => 'fa-solid fa-users',
],
];
    }

    /** Jumlah yang butuh tindakan admin (untuk badge). Dihitung sekali per request (once()). */
    public static function counts(): array
    {
        return once(fn () => [
            'orders_processing'            => Order::where('status', Order::STATUS_PROCESSING)->count(),
            'partner_pending'              => Affiliate::where('status', 'pending')->count(),
            'withdrawals_pending'          => Withdrawal::where('status', Withdrawal::STATUS_PENDING)->count(),
            'customer_withdrawals_pending' => CustomerWithdrawal::where('status', CustomerWithdrawal::STATUS_PENDING)->count(),
        ]);
    }
}
