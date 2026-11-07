@extends('layouts.admin.app')

@section('content')
@php
    $magicLoginUrl = \Illuminate\Support\Facades\URL::signedRoute('affiliate.magic_login', ['affiliate' => $affiliate->id]);
@endphp

<div x-data="{
    commissionModalOpen: false,
    toast(msg, type = 'success') {
        window.toast(type, msg); // toast standar admin (layouts/admin/toast)
    },
    copyText(text, label) {
        navigator.clipboard.writeText(text).then(() => {
            this.toast(label + ' berhasil disalin!');
        }).catch(() => {
            window.toast('error', 'Gagal menyalin ke clipboard.');
        });
    }
}">

    {{-- Page Header --}}
    <x-admin.page-header :title="'Detail Partner: ' . $affiliate->name" subtitle="Informasi profil, integrasi Lynk.id, komisi, dan riwayat aktivitas." :back="route('admin.affiliates.index')">
        <x-admin.button type="button" variant="secondary" icon="fa-solid fa-link" @click="copyText('{{ $magicLoginUrl }}', 'Magic Login Link')">
            Salin Magic Link
        </x-admin.button>
        <x-admin.button type="button" icon="fa-solid fa-plus" @click="commissionModalOpen = true">
            Tambah Komisi
        </x-admin.button>
    </x-admin.page-header>

    {{-- Alerts --}}
    @if($errors->any())
    <x-admin.alert type="error">
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </x-admin.alert>
    @endif

    {{-- Partner Info Card --}}
    <x-admin.card class="mb-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white font-bold text-lg flex items-center justify-center shrink-0 shadow-sm">
                    {{ strtoupper(substr($affiliate->name, 0, 2)) }}
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h2 class="text-xl font-bold text-slate-900">{{ $affiliate->name }}</h2>
                        @if($affiliate->status === 'pending')
                        <x-admin.badge color="yellow"><i class="fa-solid fa-clock text-[10px]"></i> Pending</x-admin.badge>
                        @elseif($affiliate->status === 'approved')
                        <x-admin.badge color="green"><i class="fa-solid fa-circle-check text-[10px]"></i> Approved</x-admin.badge>
                        @else
                        <x-admin.badge color="slate"><i class="fa-solid fa-circle-xmark text-[10px]"></i> Rejected</x-admin.badge>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $affiliate->email }}</p>

                    <div class="mt-3 flex flex-wrap items-center gap-3 text-xs">
                        <div class="inline-flex items-center gap-1.5 bg-slate-50 border border-slate-200/80 px-2.5 py-1 rounded-lg">
                            <span class="text-slate-400">Kode Referral:</span>
                            <span class="font-mono font-bold text-blue-600">{{ $affiliate->affiliate_code }}</span>
                            <button type="button" @click="copyText('{{ $affiliate->affiliate_code }}', 'Kode Referral')" class="text-slate-400 hover:text-blue-600 ml-1" title="Salin kode">
                                <i class="fa-regular fa-copy"></i>
                            </button>
                        </div>

                        <div class="inline-flex items-center gap-1.5 bg-slate-50 border border-slate-200/80 px-2.5 py-1 rounded-lg">
                            <span class="text-slate-400">Bank:</span>
                            <span class="font-medium text-slate-700">{{ $affiliate->bank_info ?: 'Belum diisi' }}</span>
                        </div>

                        <div class="text-slate-400">
                            Bergabung: <span class="text-slate-600 font-medium">{{ $affiliate->created_at?->format('d M Y') ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Balance Card --}}
            <div class="w-full md:w-auto p-4 bg-emerald-50 border border-emerald-200/80 rounded-2xl flex flex-col items-center justify-center text-center min-w-[220px]">
                <span class="text-xs font-semibold text-emerald-800 uppercase tracking-wider mb-1">Saldo Komisi</span>
                <span class="text-2xl font-bold text-emerald-700">Rp {{ number_format($affiliate->balance, 0, ',', '.') }}</span>
            </div>
        </div>
    </x-admin.card>

    {{-- Stats Mini Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-4 border border-slate-200/80 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 border border-purple-100 flex items-center justify-center text-sm shrink-0">
                <i class="fa-solid fa-hand-pointer"></i>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-medium">Total Klik</p>
                <p class="text-lg font-bold text-slate-900 mt-0.5">{{ number_format($affiliate->clicks_count ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl p-4 border border-slate-200/80 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center text-sm shrink-0">
                <i class="fa-solid fa-star"></i>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-medium">Total Poin</p>
                <p class="text-lg font-bold text-slate-900 mt-0.5">{{ number_format($affiliate->points ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl p-4 border border-slate-200/80 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 border border-orange-100 flex items-center justify-center text-sm shrink-0">
                <i class="fa-solid fa-fire"></i>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-medium">Streak Aktif</p>
                <p class="text-lg font-bold text-slate-900 mt-0.5">{{ $affiliate->current_streak ?? 0 }} <span class="text-xs font-normal text-slate-500">Hari</span></p>
            </div>
        </div>

        <div class="bg-white rounded-xl p-4 border border-slate-200/80 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 border border-rose-100 flex items-center justify-center text-sm shrink-0">
                <i class="fa-solid fa-trophy"></i>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-medium">Rekor Streak</p>
                <p class="text-lg font-bold text-slate-900 mt-0.5">{{ $affiliate->highest_streak ?? 0 }} <span class="text-xs font-normal text-slate-500">Hari</span></p>
            </div>
        </div>
    </div>

    {{-- Lynk.id & Komisi Setting Card --}}
    <x-admin.card title="Pengaturan Integrasi Lynk.id & Komisi" icon="fa-solid fa-cubes-stacked" class="mb-6">
        <p class="text-xs text-slate-500 -mt-2 mb-4">Atur link affiliate Lynk.id dan persentase komisi khusus untuk partner ini.</p>

        <form action="{{ route('admin.affiliates.lynk_settings', $affiliate->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            @csrf
            <div class="md:col-span-7">
                <x-admin.label for="lynkInput">Link Base Lynk.id Affiliate</x-admin.label>
                <x-admin.input type="url" name="lynk_id_link" id="lynkInput" :value="old('lynk_id_link', $affiliate->lynk_id_link)" placeholder="https://lynk.id/a/1035009226" />
                <x-admin.hint for="lynk_id_link">Link halaman Lynk.id yang dituju oleh referral partner.</x-admin.hint>
            </div>

            <div class="md:col-span-3">
                <x-admin.label for="rateInput" required>Persentase Komisi (%)</x-admin.label>
                <x-admin.input type="number" step="0.1" min="0" max="100" name="lynk_commission_rate" id="rateInput" :value="old('lynk_commission_rate', (float)($affiliate->lynk_commission_rate ?? 10.00))" required />
                <x-admin.hint for="lynk_commission_rate">Besaran rate komisi per deal (default: 10%).</x-admin.hint>
            </div>

            <div class="md:col-span-2">
                <x-admin.button type="submit" class="w-full" icon="fa-solid fa-floppy-disk">
                    Simpan
                </x-admin.button>
            </div>
        </form>
    </x-admin.card>

    {{-- Activity & History 2-Column Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

        {{-- Column 1: Riwayat Komisi & Template Chat --}}
        <div class="space-y-6">

            {{-- Riwayat Komisi --}}
            <x-admin.card :padding="false">
                <div class="p-4 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-wallet text-emerald-600 text-sm"></i>
                        <h3 class="font-semibold text-sm text-slate-800">Riwayat Komisi Masuk</h3>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs">
                        <thead class="bg-slate-50 text-left uppercase text-slate-400 font-semibold tracking-wider">
                            <tr>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Keterangan</th>
                                <th class="px-4 py-3 text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600">
                            @forelse($commissions as $comm)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap text-slate-400">{{ $comm->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-4 py-3 font-medium text-slate-800">{{ $comm->description ?? 'Komisi Project' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap font-bold text-emerald-600 text-right">+Rp {{ number_format($comm->amount, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-slate-400">
                                    <i class="fa-solid fa-wallet text-2xl text-slate-300 mb-1.5 block"></i>
                                    Belum ada riwayat komisi.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($commissions->hasPages())
                <div class="p-3 border-t border-slate-200">
                    {{ $commissions->links('pagination::tailwind') }}
                </div>
                @endif
            </x-admin.card>

            {{-- Template Chat Dibuat --}}
            <x-admin.card :padding="false">
                <div class="p-4 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-message text-indigo-600 text-sm"></i>
                        <h3 class="font-semibold text-sm text-slate-800">Template Chat Dibuat</h3>
                    </div>
                    <span class="text-xs text-slate-400 font-mono">{{ $chatTemplates->count() }} template</span>
                </div>

                <div class="max-h-[360px] overflow-y-auto divide-y divide-slate-100">
                    @forelse($chatTemplates as $ct)
                    <div class="p-4 hover:bg-slate-50/70 transition-colors">
                        <div class="flex justify-between items-start gap-2 mb-2">
                            <h4 class="font-semibold text-xs text-slate-800">{{ $ct->name }}</h4>
                            @if($ct->businessCategory)
                            <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $ct->businessCategory->name }}
                            </span>
                            @endif
                        </div>
                        <p class="text-[11px] text-slate-600 bg-slate-50 p-2.5 rounded-lg font-mono whitespace-pre-wrap border border-slate-200/60 leading-relaxed">{{ Str::limit($ct->content, 140) }}</p>
                    </div>
                    @empty
                    <div class="px-4 py-8 text-center text-slate-400 text-xs">
                        <i class="fa-regular fa-message text-2xl text-slate-300 mb-1.5 block"></i>
                        Belum ada template chat yang dibuat oleh partner ini.
                    </div>
                    @endforelse
                </div>
            </x-admin.card>

        </div>

        {{-- Column 2: Riwayat Penarikan & Aktivitas Poin --}}
        <div class="space-y-6">

            {{-- Riwayat Penarikan --}}
            <x-admin.card :padding="false">
                <div class="p-4 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-money-bill-transfer text-blue-600 text-sm"></i>
                        <h3 class="font-semibold text-sm text-slate-800">Riwayat Penarikan Saldo</h3>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs">
                        <thead class="bg-slate-50 text-left uppercase text-slate-400 font-semibold tracking-wider">
                            <tr>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3 text-right">Nominal</th>
                                <th class="px-4 py-3 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600">
                            @forelse($withdrawals as $wd)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap text-slate-400">{{ $wd->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-4 py-3 whitespace-nowrap font-bold text-slate-900 text-right">Rp {{ number_format($wd->amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-right">
                                    @if($wd->status === 'Pending')
                                    <x-admin.badge color="yellow">Pending</x-admin.badge>
                                    @elseif($wd->status === 'Completed')
                                    <x-admin.badge color="green">Selesai</x-admin.badge>
                                    @else
                                    <x-admin.badge color="slate">Ditolak</x-admin.badge>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-slate-400">
                                    <i class="fa-solid fa-money-bill-transfer text-2xl text-slate-300 mb-1.5 block"></i>
                                    Belum ada riwayat penarikan saldo.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($withdrawals->hasPages())
                <div class="p-3 border-t border-slate-200">
                    {{ $withdrawals->links('pagination::tailwind') }}
                </div>
                @endif
            </x-admin.card>

            {{-- Aktivitas Poin (Login & Streak) --}}
            <x-admin.card :padding="false">
                <div class="p-4 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-amber-600 text-sm"></i>
                        <h3 class="font-semibold text-sm text-slate-800">Aktivitas Poin & Streak</h3>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs">
                        <thead class="bg-slate-50 text-left uppercase text-slate-400 font-semibold tracking-wider">
                            <tr>
                                <th class="px-4 py-3">Waktu Klaim</th>
                                <th class="px-4 py-3">Aktivitas</th>
                                <th class="px-4 py-3 text-right">Poin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600">
                            @forelse($pointHistories as $ph)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap text-slate-400">{{ $ph->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-4 py-3 font-medium text-slate-800">{{ $ph->description }}</td>
                                <td class="px-4 py-3 whitespace-nowrap font-bold text-amber-600 text-right">+{{ number_format($ph->points_earned, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-slate-400">
                                    <i class="fa-solid fa-list-check text-2xl text-slate-300 mb-1.5 block"></i>
                                    Belum ada aktivitas poin.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($pointHistories->hasPages())
                <div class="p-3 border-t border-slate-200">
                    {{ $pointHistories->links('pagination::tailwind') }}
                </div>
                @endif
            </x-admin.card>

        </div>

    </div>

    {{-- Modal Tambah Komisi Partner --}}
    <div x-show="commissionModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="commissionModalOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

        <div class="min-h-full p-4 flex items-center justify-center">
            <div x-show="commissionModalOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                @click.away="commissionModalOpen = false"
                class="relative w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 p-6 z-10">

                <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <i class="fa-solid fa-wallet text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-slate-900">Tambah Komisi Partner</h3>
                            <p class="text-xs text-slate-400">Input reward komisi hasil deal project.</p>
                        </div>
                    </div>
                    <button type="button" @click="commissionModalOpen = false" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <div class="mb-4 p-3 bg-blue-50 border border-blue-100 rounded-xl text-xs flex items-center justify-between">
                    <span class="text-blue-700 font-medium">Partner:</span>
                    <span class="font-bold text-blue-900 truncate max-w-[200px]">{{ $affiliate->name }}</span>
                </div>

                <form action="{{ route('admin.affiliates.commission', $affiliate->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <x-admin.label for="commissionDesc" required>Keterangan / Dari Project Apa?</x-admin.label>
                        <x-admin.input name="description" id="commissionDesc" required placeholder="Contoh: Komisi Project Web E-Commerce PT XYZ" />
                        <x-admin.hint for="description">Deskripsi project yang berhasil deal.</x-admin.hint>
                    </div>

                    <div>
                        <x-admin.label for="commissionAmount" required>Nominal Komisi (Rp)</x-admin.label>
                        <x-admin.input type="number" name="amount" id="commissionAmount" min="1000" required placeholder="Contoh: 150000" />
                        <x-admin.hint for="amount">Nominal dalam Rupiah (min. Rp 1.000).</x-admin.hint>
                    </div>

                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800 leading-relaxed">
                        <div class="flex items-start gap-2">
                            <i class="fa-solid fa-circle-info text-amber-600 mt-0.5"></i>
                            <div>
                                <span class="font-semibold">Informasi Sistem:</span>
                                <p class="mt-0.5 text-amber-700">Komisi default partner adalah 10% dari total deal project. Memberikan komisi otomatis menambahkan <b>+100 Poin</b> ke streak partner.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                        <x-admin.button type="button" variant="secondary" @click="commissionModalOpen = false">Batal</x-admin.button>
                        <x-admin.button type="submit" icon="fa-solid fa-floppy-disk">Tambahkan Komisi</x-admin.button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
@endsection
