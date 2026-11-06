{{--
    Email status order topup: tema terang & profesional (kebanyakan email client berlatar putih).
    Aksen brand biru #2563EB, logo di-embed (CID) agar tampil tanpa bergantung APP_URL.
    font-family ditulis di setiap elemen teks karena beberapa client membuang style <body>.
--}}
@php
$brand = config('mail.from.name');
$meta = [
'paid' => [
'message' => 'Terima kasih, pembayaranmu sudah kami terima. Pesanan sedang diproses dan biasanya masuk ke akun tujuan dalam beberapa menit.',
'icon' => '&#8635;', 'color' => '#2563EB', 'soft' => '#EFF6FF', 'ring' => '#BFDBFE',
],
'success' => [
'message' => "Pesananmu sudah berhasil dikirim ke akun tujuan. Terima kasih sudah bertransaksi di {$brand}.",
'icon' => '&#10003;', 'color' => '#059669', 'soft' => '#ECFDF5', 'ring' => '#A7F3D0',
],
'failed' => [
'message' => 'Mohon maaf, pesananmu gagal diproses oleh sistem. Silakan hubungi admin dengan menyertakan nomor order di bawah agar segera kami bantu.',
'icon' => '&#33;', 'color' => '#DC2626', 'soft' => '#FEF2F2', 'ring' => '#FECACA',
],
][$event];

$rupiah = fn ($v) => 'Rp ' . number_format((float) $v, 0, ',', '.');
$font = "'Plus Jakarta Sans','Segoe UI',Roboto,Helvetica,Arial,sans-serif";
$mono = "Menlo,Consolas,'Courier New',monospace";
$label = "white-space:nowrap;padding:10px 12px 10px 0;border-top:1px solid #EEF1F6;font-family:{$font};font-size:13px;color:#64748B;";
$value = "padding:10px 0;border-top:1px solid #EEF1F6;font-family:{$font};font-size:13px;color:#0F172A;font-weight:600;text-align:right;";

// Saat dikirim: logo di-embed (CID). Saat preview/render biasa ($message tidak ada): URL publik.
$logoPath = public_path('scalify.png');
$logo = isset($message) && is_file($logoPath) ? $message->embed($logoPath) : asset('scalify.png');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>{{ $meta['title'] }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body style="margin:0;padding:0;background-color:#F4F6FB;">
    <div style="display:none;max-height:0;overflow:hidden;opacity:0;">{{ $meta['title'] }} &middot; Order {{ $order->order_no }} &middot; {{ $order->product_name }}</div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" bgcolor="#F4F6FB" style="background-color:#F4F6FB;">
        <tr>
            <td align="center" style="padding:32px 12px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;">

                    {{-- Header logo --}}
                    <tr>
                        <td style="padding:0 4px 20px;">
                            <table role="presentation" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td valign="middle" style="padding-right:12px;">
                                        <img src="{{ $logo }}" width="44" height="44" alt="{{ $brand }}" style="display:block;width:44px;height:44px;border-radius:10px;border:1px solid #E2E8F0;background-color:#FFFFFF;">
                                    </td>
                                    <td valign="middle">
                                        <div style="font-family:{!! $font !!};font-size:16px;font-weight:800;color:#0F172A;letter-spacing:-0.01em;">{{ $brand }}</div>
                                        <div style="font-family:{!! $font !!};font-size:12px;color:#64748B;margin-top:2px;">Top Up Game &amp; Produk Digital</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Kartu utama --}}
                    <tr>
                        <td bgcolor="#FFFFFF" style="background-color:#FFFFFF;border:1px solid #E2E8F0;border-radius:16px;padding:32px 28px;">

                            {{-- Status --}}
                            <table role="presentation" cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td width="64" height="64" align="center" valign="middle" bgcolor="{{ $meta['soft'] }}" style="width:64px;height:64px;border-radius:32px;background-color:{{ $meta['soft'] }};border:2px solid {{ $meta['ring'] }};font-family:Arial,sans-serif;font-size:30px;font-weight:bold;line-height:60px;color:{{ $meta['color'] }};">{!! $meta['icon'] !!}</td>
                                </tr>
                            </table>

                            <div style="text-align:center;margin-top:16px;">
                                <span style="display:inline-block;padding:4px 12px;border-radius:999px;background-color:{{ $meta['soft'] }};font-family:{!! $font !!};font-size:11px;font-weight:700;letter-spacing:0.04em;text-transform:uppercase;color:{{ $meta['color'] }};">{{ $meta['badge'] }}</span>
                            </div>

                            <h1 style="margin:12px 0 0;text-align:center;font-family:{!! $font !!};font-size:24px;line-height:1.3;font-weight:800;letter-spacing:-0.02em;color:#0F172A;">{{ $meta['title'] }}</h1>
                            <p style="margin:8px auto 0;max-width:420px;text-align:center;font-family:{!! $font !!};font-size:14px;line-height:1.65;color:#475569;">{{ $meta['message'] }}</p>

                            {{-- Rincian pesanan --}}
                            <div style="margin-top:28px;font-family:{!! $font !!};font-size:12px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:#94A3B8;">Rincian Pesanan</div>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:6px;">
                                <tr>
                                    <td style="{{ $label }}">No. Order</td>
                                    <td style="{{ $value }}font-family:{!! $mono !!};white-space:nowrap;">{{ $order->order_no }}</td>
                                </tr>
                                <tr>
                                    <td style="{{ $label }}">Produk</td>
                                    <td style="{{ $value }}">{{ $order->product_name }}</td>
                                </tr>
                                @if ($order->account_data)
                                @foreach ($order->account_data as $key => $val)
                                <tr>
                                    <td style="{{ $label }}">{{ preg_replace('/\bId\b/', 'ID', \Illuminate\Support\Str::headline($key)) }}</td>
                                    <td style="{{ $value }}">{{ $val }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td style="{{ $label }}">No. Tujuan</td>
                                    <td style="{{ $value }}">{{ $order->customer_no }}</td>
                                </tr>
                                @endif
                                @if ($order->paid_at)
                                <tr>
                                    <td style="{{ $label }}">Waktu Bayar</td>
                                    <td style="{{ $value }}">{{ $order->paid_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</td>
                                </tr>
                                @endif
                                @if ($order->payment_method)
                                <tr>
                                    <td style="{{ $label }}">Metode Bayar</td>
                                    <td style="{{ $value }}">{{ mb_strtoupper($order->payment_method) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="white-space:nowrap;padding:14px 12px 0 0;border-top:1px solid #CBD5E1;font-family:{!! $font !!};font-size:14px;font-weight:700;color:#0F172A;">Total Dibayar</td>
                                    <td style="padding:14px 0 0;border-top:1px solid #CBD5E1;font-family:{!! $font !!};font-size:18px;font-weight:800;color:#2563EB;text-align:right;">{{ $rupiah($order->total_amount) }}</td>
                                </tr>
                            </table>

                            @if ($event === 'success' && $order->sn)
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" bgcolor="#F8FAFC" style="margin-top:22px;background-color:#F8FAFC;border:1px dashed #CBD5E1;border-radius:12px;">
                                <tr>
                                    <td style="padding:14px 16px;">
                                        <div style="font-family:{!! $font !!};font-size:11px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:#64748B;">Serial Number / Kode</div>
                                        <div style="margin-top:4px;font-family:{!! $mono !!};font-size:14px;color:#0F172A;word-break:break-all;">{{ $order->sn }}</div>
                                    </td>
                                </tr>
                            </table>
                            @endif

                            {{-- Tombol --}}
                            <table role="presentation" cellpadding="0" cellspacing="0" align="center" style="margin-top:28px;">
                                <tr>
                                    <td align="center" bgcolor="#2563EB" style="border-radius:10px;background-color:#2563EB;">
                                        <a href="{{ route('topup.index') }}" style="display:inline-block;padding:13px 32px;font-family:{!! $font !!};font-size:14px;font-weight:700;color:#FFFFFF;text-decoration:none;">Top Up Lagi</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding:24px 16px 0;text-align:center;font-family:{!! $font !!};font-size:12px;line-height:1.7;color:#94A3B8;">
                            Simpan email ini sebagai bukti transaksi yang sah.<br>
                            Email ini dikirim otomatis, mohon tidak membalas email ini.<br>
                            &copy; {{ date('Y') }} {{ $brand }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
