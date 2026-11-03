{{--
    Form Review Card — dipakai oleh create & edit.
    Variabel: $card (object|null)
--}}
@php
$card = $card ?? null;
$isEdit = $card !== null;
@endphp

@if ($errors->any())
<x-admin.alert type="error">
    <p class="font-medium mb-1">Periksa kembali data yang diisi:</p>
    <ul class="list-disc list-inside space-y-0.5">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</x-admin.alert>
@endif

<form id="reviewCardForm" method="POST" action="{{ $isEdit ? route('admin.review_cards.update', $card->id) : route('admin.review_cards.store') }}">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- ================= Kolom utama ================= --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Section 1: Identitas Fisik --}}
            <x-admin.card title="1. Identitas Fisik Produk" icon="fa-solid fa-microchip">
                @if ($isEdit)
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200/80 text-xs">
                    <div>
                        <span class="text-slate-400 block font-medium uppercase">Nomor Serial</span>
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
                        <span class="text-slate-400 block font-medium uppercase">PIN / Total Scan</span>
                        <span class="font-mono font-bold text-slate-800">{{ $card->activation_code }}</span>
                        <span class="text-slate-500 font-normal ml-1">({{ number_format($card->total_scans ?? 0) }} scan)</span>
                    </div>
                </div>
                @else
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <x-admin.label for="serialNumberInput" required>Nomor Serial</x-admin.label>
                        <x-admin.input name="serial_number" id="serialNumberInput" :value="old('serial_number', $defaultSerial ?? '')" required maxlength="64" class="font-mono text-xs uppercase" />
                        <x-admin.hint for="serial_number">Format: SCL-XXXXXX</x-admin.hint>
                    </div>

                    <div>
                        <x-admin.label for="slugInput" required>Slug Scan (/r/{slug})</x-admin.label>
                        <x-admin.input name="slug" id="slugInput" :value="old('slug', $defaultSlug ?? '')" required maxlength="64" class="font-mono text-xs" />
                        <x-admin.hint for="slug">Tujuan redirect QR/NFC.</x-admin.hint>
                    </div>

                    <div>
                        <x-admin.label for="pinInput" required>Kode / PIN Aktivasi</x-admin.label>
                        <x-admin.input name="activation_code" id="pinInput" :value="old('activation_code', $defaultPin ?? '')" required maxlength="32" class="font-mono text-xs" />
                        <x-admin.hint for="activation_code">6 digit PIN keamanan.</x-admin.hint>
                    </div>
                </div>
                @endif
            </x-admin.card>

            {{-- Section 2: Data Bisnis Klien --}}
            <x-admin.card title="2. Data Bisnis Klien" icon="fa-solid fa-store">
                <div class="space-y-4">
                    <div>
                        <x-admin.label for="businessNameInput">Nama Tempat Bisnis / Kafe / Usaha</x-admin.label>
                        <x-admin.input name="business_name" id="businessNameInput" :value="old('business_name', $card?->business_name)" maxlength="255" placeholder="Contoh: Kopi Kenangan Mall Paris Van Java" />
                        <x-admin.hint for="business_name">Nama usaha yang akan muncul saat scan stiker/kartu.</x-admin.hint>
                    </div>

                    <div>
                        <x-admin.label for="googleReviewUrlInput">Link Google Review Bisnis</x-admin.label>
                        <x-admin.input type="url" name="google_review_url" id="googleReviewUrlInput" :value="old('google_review_url', $card?->google_review_url)" placeholder="https://g.page/r/... atau https://maps.app.goo.gl/..." />
                        <x-admin.hint for="google_review_url">URL tujuan Google Reviews saat pengunjung melakukan tap NFC atau scan QR.</x-admin.hint>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-admin.label for="ownerNameInput">Nama Pemilik / Klien</x-admin.label>
                            <x-admin.input name="owner_name" id="ownerNameInput" :value="old('owner_name', $card?->owner_name)" maxlength="255" placeholder="Contoh: Budi Santoso" />
                        </div>

                        <div>
                            <x-admin.label for="ownerPhoneInput">No. WhatsApp Pemilik</x-admin.label>
                            <x-admin.input name="owner_phone" id="ownerPhoneInput" :value="old('owner_phone', $card?->owner_phone)" maxlength="50" placeholder="08xxxxxxxxxx" />
                        </div>
                    </div>

                    <div>
                        <x-admin.label for="notesInput">Catatan Internal</x-admin.label>
                        <x-admin.input name="notes" id="notesInput" :value="old('notes', $card?->notes)" placeholder="Contoh: Paket 1x Kartu NFC Meja Kasir" />
                        <x-admin.hint for="notes">Catatan nomor batch atau lokasi penempatan kartu.</x-admin.hint>
                    </div>
                </div>
            </x-admin.card>

        </div>

        {{-- ================= Sidebar ================= --}}
        <div class="space-y-6 lg:sticky lg:top-0">

            <x-admin.card title="Status & Pengaturan" icon="fa-solid fa-sliders">
                <div class="space-y-4">
                    <div>
                        <x-admin.label for="statusInput" required>Status Kartu</x-admin.label>
                        <x-admin.select name="status" id="statusInput">
                            <option value="pending" {{ old('status', $card?->status ?? 'pending') === 'pending' ? 'selected' : '' }}>Pending (Gudang / Belum Aktif)</option>
                            <option value="active" {{ old('status', $card?->status) === 'active' ? 'selected' : '' }}>Active (Aktif Digunakan)</option>
                            <option value="inactive" {{ old('status', $card?->status) === 'inactive' ? 'selected' : '' }}>Inactive (Nonaktifkan Sementara)</option>
                        </x-admin.select>
                        <x-admin.hint for="status">Kartu berstatus Active akan langsung dialihkan ke URL Google Review.</x-admin.hint>
                    </div>

                    @if ($isEdit)
                    <div class="p-3.5 bg-amber-50 border border-amber-200 rounded-xl">
                        <label class="flex items-start gap-2.5 cursor-pointer">
                            <input type="checkbox" name="is_sold" id="is_sold" value="1" {{ old('is_sold', $card->is_sold) ? 'checked' : '' }} class="mt-0.5 rounded text-blue-600 focus:ring-blue-500">
                            <div class="text-xs text-amber-900">
                                <span class="font-bold block">Tandai Sebagai Terjual</span>
                                <span class="text-amber-700 text-[11px] leading-relaxed block mt-0.5">Centang jika kartu sudah terjual ke klien. Kartu yang terjual akan dikunci permanen.</span>
                            </div>
                        </label>
                    </div>
                    @endif
                </div>

                <div class="mt-5 pt-5 border-t border-slate-200 space-y-2">
                    <x-admin.button type="submit" class="w-full" icon="fa-solid fa-floppy-disk">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Review Card' }}
                    </x-admin.button>
                    <x-admin.button variant="secondary" class="w-full" :href="route('admin.review_cards.index')">
                        Batal
                    </x-admin.button>
                </div>

                @if ($isEdit)
                <dl class="mt-5 pt-5 border-t border-slate-200 space-y-2 text-xs">
                    <div class="flex justify-between gap-3">
                        <dt class="text-slate-500">ID Kartu</dt>
                        <dd class="text-slate-700 font-mono font-medium">#{{ $card->id }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-slate-500">Total Scan</dt>
                        <dd class="text-slate-700 font-bold font-mono">{{ number_format($card->total_scans ?? 0) }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-slate-500">Dibuat</dt>
                        <dd class="text-slate-700 font-medium">{{ \Carbon\Carbon::parse($card->created_at)->format('d M Y, H:i') }}</dd>
                    </div>
                    @if ($card->activated_at)
                    <div class="flex justify-between gap-3">
                        <dt class="text-slate-500">Diaktifkan</dt>
                        <dd class="text-slate-700 font-medium">{{ \Carbon\Carbon::parse($card->activated_at)->format('d M Y, H:i') }}</dd>
                    </div>
                    @endif
                </dl>
                @endif
            </x-admin.card>

        </div>

    </div>
</form>
