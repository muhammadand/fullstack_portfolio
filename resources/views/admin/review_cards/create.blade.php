@extends('layouts.admin.app')

@section('content')
<div class="px-4 lg:px-6 py-6 lg:py-8 max-w-4xl mx-auto">

    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2.5">
                <i class="fa-solid fa-plus-circle text-blue-600"></i>
                Tambah Review Card Baru
            </h1>
            <p class="text-slate-500 text-sm mt-1">Buat unit kartu/stiker QR secara satuan dengan parameter kustom.</p>
        </div>
        <a href="{{ route('admin.review_cards.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-800 text-sm font-medium transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl mb-6 text-sm">
        <p class="font-bold mb-1">Ada beberapa kesalahan:</p>
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 lg:p-8">
        <form action="{{ route('admin.review_cards.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Section 1: Identitas Kartu -->
            <div>
                <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-microchip text-slate-400"></i>
                    1. Identitas Fisik Produk
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nomor Serial</label>
                        <input type="text" name="serial_number" value="{{ old('serial_number', $defaultSerial) }}" required class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm font-mono focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Slug URL Scan (/r/{slug})</label>
                        <input type="text" name="slug" value="{{ old('slug', $defaultSlug) }}" required class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm font-mono focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kode / PIN Aktivasi</label>
                        <input type="text" name="activation_code" value="{{ old('activation_code', $defaultPin) }}" required class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm font-mono focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
            </div>

            <!-- Section 2: Data Aktivasi / Bisnis (Bisa dikosongkan jika masih di gudang) -->
            <div>
                <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-store text-slate-400"></i>
                    2. Data Bisnis Klien (Opsional saat cetak)
                </h2>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Status Kartu</label>
                            <select name="status" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                                <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending (Belum Diaktifkan / Masih di Gudang)</option>
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active (Langsung Aktif)</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive (Nonaktif)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Tempat Bisnis / Kafe</label>
                            <input type="text" name="business_name" value="{{ old('business_name') }}" placeholder="Contoh: Kopi Titik Koma Bandung" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Link Google Review Bisnis</label>
                        <input type="url" name="google_review_url" value="{{ old('google_review_url') }}" placeholder="https://g.page/r/... atau https://maps.app.goo.gl/..." class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <p class="text-[11px] text-slate-400 mt-1">Target tujuan saat pelanggan akhir melakukan scan/tap stiker.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Pembeli / Pemilik</label>
                            <input type="text" name="owner_name" value="{{ old('owner_name') }}" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">No. WhatsApp Pemilik</label>
                            <input type="text" name="owner_phone" value="{{ old('owner_phone') }}" placeholder="08xxxxxxxxxx" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Catatan Internal</label>
                        <input type="text" name="notes" value="{{ old('notes') }}" placeholder="Contoh: Paket 1x Kartu NFC Meja Kasir" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.review_cards.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition-colors">
                    Simpan Kartu
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
