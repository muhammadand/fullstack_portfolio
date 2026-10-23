@extends('layouts.admin.app')

@section('content')
<div class="px-4 lg:px-6 py-6 lg:py-8 max-w-4xl mx-auto">

    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2.5">
                <i class="fa-solid fa-pen-to-square text-blue-600"></i>
                Edit Review Card: <span class="font-mono text-blue-600">{{ $card->serial_number }}</span>
            </h1>
            <p class="text-slate-500 text-sm mt-1">Perbarui konfigurasi URL Google Review atau status aktivasi kartu.</p>
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
        <!-- Info Ringkas Identitas Statis -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200/80 mb-6 text-xs">
            <div>
                <span class="text-slate-400 block font-medium uppercase">Nomor Serial (Permanen)</span>
                <span class="font-mono font-bold text-slate-800 text-sm">{{ $card->serial_number }}</span>
            </div>
            <div>
                <span class="text-slate-400 block font-medium uppercase">URL Scan Konsumen</span>
                <a href="{{ url('/r/' . $card->slug) }}" target="_blank" class="font-mono text-blue-600 font-semibold hover:underline flex items-center gap-1 mt-0.5">
                    /r/{{ $card->slug }}
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                </a>
            </div>
            <div>
                <span class="text-slate-400 block font-medium uppercase">PIN Aktivasi / Total Scan</span>
                <span class="font-mono font-bold text-slate-800">{{ $card->activation_code }}</span>
                <span class="text-slate-500 font-normal ml-2">({{ number_format($card->total_scans) }} scans)</span>
            </div>
        </div>

        <form action="{{ route('admin.review_cards.update', $card->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Status Kartu</label>
                        <select name="status" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="pending" {{ old('status', $card->status) === 'pending' ? 'selected' : '' }}>Pending (Gudang / Belum Aktif)</option>
                            <option value="active" {{ old('status', $card->status) === 'active' ? 'selected' : '' }}>Active (Aktif Digunakan)</option>
                            <option value="inactive" {{ old('status', $card->status) === 'inactive' ? 'selected' : '' }}>Inactive (Nonaktifkan Sementara)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Tempat Bisnis / Kafe</label>
                        <input type="text" name="business_name" value="{{ old('business_name', $card->business_name) }}" placeholder="Contoh: Kopi Kenangan Mall Paris Van Java" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Link Google Review Bisnis</label>
                    <input type="url" name="google_review_url" value="{{ old('google_review_url', $card->google_review_url) }}" placeholder="https://g.page/r/... atau https://maps.app.goo.gl/..." class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <p class="text-[11px] text-slate-400 mt-1">Jika status 'Active', setiap ada pelanggan yang scan langsung dialihkan ke link ini.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Pemilik / Klien</label>
                        <input type="text" name="owner_name" value="{{ old('owner_name', $card->owner_name) }}" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">No. WhatsApp Pemilik</label>
                        <input type="text" name="owner_phone" value="{{ old('owner_phone', $card->owner_phone) }}" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Catatan Internal</label>
                    <input type="text" name="notes" value="{{ old('notes', $card->notes) }}" placeholder="Catatan no pesanan / lokasi meja" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div class="p-3.5 bg-amber-50 border border-amber-200 rounded-xl flex items-start gap-3">
                    <input type="checkbox" name="is_sold" id="is_sold" value="1" {{ old('is_sold', $card->is_sold) ? 'checked' : '' }} class="mt-0.5 rounded text-blue-600 focus:ring-blue-500">
                    <label for="is_sold" class="text-xs text-amber-900 cursor-pointer">
                        <span class="font-bold block">Tandai Sebagai Terjual (Kunci Kartu)</span>
                        <span class="text-amber-700">Centang opsi ini jika kartu telah diserahkan/terjual ke klien. Kartu yang ditandai terjual akan dikunci permanen.</span>
                    </label>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.review_cards.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
