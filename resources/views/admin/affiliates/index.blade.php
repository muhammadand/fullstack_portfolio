@extends('layouts.admin.app')

@section('content')
<div x-data="{
    addModalOpen: false,
    commissionModalOpen: false,
    selectedAffiliateId: null,
    selectedAffiliateName: '',
    toast(msg, type = 'success') {
        window.toast(type, msg); // toast standar admin (layouts/admin/toast)
    },
    openCommission(id, name) {
        this.selectedAffiliateId = id;
        this.selectedAffiliateName = name;
        this.commissionModalOpen = true;
    },
    copyMagicLink(url) {
        navigator.clipboard.writeText(url).then(() => {
            this.toast('Magic Login link berhasil disalin!');
        }).catch(() => {
            window.toast('error', 'Gagal menyalin link.');
        });
    },
    async sendBroadcast() {
        if (!(await confirmDialog({ title: 'Kirim notifikasi?', text: 'Kirim notifikasi Push (Semangat Pagi) ke semua Partner sekarang?', confirmText: 'Kirim' }))) return;
        fetch('/api/cron/send-daily-push?secret=cuan-tiap-hari')
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.toast(data.message);
                } else {
                    this.toast(data.message || data.error || 'Gagal mengirim', 'warning');
                }
            })
            .catch(err => {
                window.toast('error', 'Terjadi kesalahan: ' + err);
            });
    }
}">

    {{-- Page Header --}}
    <x-admin.page-header title="Affiliate Dashboard" subtitle="Pantau performa partner dan kelola komisi di satu tempat.">
        <x-admin.button type="button" variant="secondary" icon="fa-solid fa-bell" @click="sendBroadcast()">
            Broadcast Notif
        </x-admin.button>
        <x-admin.button type="button" icon="fa-solid fa-plus" @click="addModalOpen = true">
            Tambah Partner
        </x-admin.button>
    </x-admin.page-header>

    {{-- Dashboard Stats Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 lg:gap-4 mb-5 lg:mb-6">
        <x-admin.stat label="Total Partner" :value="$totalPartners" icon="fa-solid fa-users" tone="blue" />
        <x-admin.stat label="Total Klik" :value="$totalClicks" icon="fa-solid fa-hand-pointer" tone="purple" />
        <x-admin.stat label="Komisi Diberikan" :value="$totalCommissions" rupiah icon="fa-solid fa-wallet" tone="emerald" />
        <x-admin.stat label="Perlu Approval" :value="$totalPending" icon="fa-solid fa-user-clock" :tone="$totalPending > 0 ? 'amber' : 'slate'"
            :href="route('admin.affiliates.index', ['status' => 'pending'])" />
    </div>

    {{-- Alerts --}}
    @if($errors->any())
    <x-admin.alert type="error">
        <p class="font-medium mb-1">Periksa kembali data yang diinput:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </x-admin.alert>
    @endif

    {{-- Main Table Card --}}
    <x-admin.card :padding="false">
        {{-- Toolbar Filter & Search --}}
        <x-admin.filter-bar name="q" :value="request('q')" placeholder="Cari nama, email, kode partner..."
            :active="(int) filled(request('status'))" :reset="route('admin.affiliates.index')">
            <x-admin.select name="status" class="col-span-2 lg:w-44">
                <option value="">Semua Status</option>
                <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
            </x-admin.select>
        </x-admin.filter-bar>

        {{-- Desktop & Tablet Table View --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-4 py-3 w-12">#</th>
                        <th class="px-4 py-3">Partner</th>
                        <th class="px-4 py-3 text-center">Performa</th>
                        <th class="px-4 py-3">Saldo Komisi</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600">
                    @forelse($affiliates as $affiliate)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-4 py-3 text-slate-400">{{ $affiliates->firstItem() + $loop->index }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.affiliates.show', $affiliate->id) }}" class="font-medium text-slate-900 hover:text-blue-600 block">
                                {{ $affiliate->name }}
                            </a>
                            <span class="text-xs text-slate-500 block">{{ $affiliate->email }}</span>
                            <div class="text-[11px] text-slate-400 mt-1 flex items-center gap-1.5">
                                <span>Kode:</span>
                                <span class="font-mono font-semibold text-blue-700 bg-blue-50 border border-blue-200/70 px-1.5 py-0.5 rounded text-[10px]">
                                    {{ $affiliate->affiliate_code }}
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-purple-50 text-purple-700 border border-purple-200/50 rounded-lg text-xs font-medium">
                                <i class="fa-solid fa-hand-pointer text-[10px]"></i> {{ number_format($affiliate->clicks_count ?? 0, 0, ',', '.') }} Klik
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="font-bold text-slate-900 text-sm">
                                Rp {{ number_format($affiliate->balance, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-slate-400 truncate max-w-[180px]" title="{{ $affiliate->bank_info }}">
                                {{ $affiliate->bank_info ?: 'Belum ada rekening' }}
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($affiliate->status === 'pending')
                            <x-admin.badge color="yellow">
                                <i class="fa-solid fa-clock text-[10px]"></i> Pending
                            </x-admin.badge>
                            @elseif($affiliate->status === 'approved')
                            <x-admin.badge color="green">
                                <i class="fa-solid fa-circle-check text-[10px]"></i> Approved
                            </x-admin.badge>
                            @else
                            <x-admin.badge color="slate">
                                <i class="fa-solid fa-circle-xmark text-[10px]"></i> Rejected
                            </x-admin.badge>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-1.5 whitespace-nowrap">
                                @if($affiliate->status === 'pending')
                                <form action="{{ route('admin.affiliates.approve', $affiliate->id) }}" method="POST">
                                    @csrf
                                    <x-admin.button type="submit" size="sm" icon="fa-solid fa-check">Approve</x-admin.button>
                                </form>
                                <form action="{{ route('admin.affiliates.reject', $affiliate->id) }}" method="POST" data-confirm="Apakah Anda yakin ingin menolak partner ini?" data-confirm-danger>
                                    @csrf
                                    <x-admin.button type="submit" variant="danger" size="sm" icon="fa-solid fa-xmark">Reject</x-admin.button>
                                </form>
                                @elseif($affiliate->status === 'approved')
                                @php
                                    $magicLoginUrl = \Illuminate\Support\Facades\URL::signedRoute('affiliate.magic_login', ['affiliate' => $affiliate->id]);
                                @endphp
                                <x-admin.button type="button" variant="secondary" size="sm" icon="fa-solid fa-link" @click="copyMagicLink('{{ $magicLoginUrl }}')" title="Salin Magic Login Link">
                                    Link
                                </x-admin.button>
                                <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-eye" :href="route('admin.affiliates.show', $affiliate->id)">
                                    Detail
                                </x-admin.button>
                                <x-admin.button type="button" size="sm" icon="fa-solid fa-plus" @click="openCommission({{ $affiliate->id }}, '{{ addslashes($affiliate->name) }}')">
                                    Komisi
                                </x-admin.button>
                                @else
                                <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-eye" :href="route('admin.affiliates.show', $affiliate->id)">
                                    Detail
                                </x-admin.button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                <i class="fa-solid fa-users-slash text-xl"></i>
                            </div>
                            <p class="text-sm font-medium text-slate-700">
                                {{ request('q') || request('status') ? 'Tidak ada partner yang cocok dengan filter.' : 'Belum ada partner affiliate terdaftar.' }}
                            </p>
                            <p class="text-xs text-slate-400 mt-1">
                                {{ request('q') || request('status') ? 'Coba ganti kata kunci pencarian atau reset filter.' : 'Gunakan tombol Tambah Partner untuk mendaftarkan partner baru.' }}
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- HP: kartu --}}
        <div class="md:hidden divide-y divide-slate-100">
            @forelse($affiliates as $affiliate)
            <div class="p-4">
                <div class="flex items-start justify-between gap-3">
                    <a href="{{ route('admin.affiliates.show', $affiliate->id) }}" class="min-w-0">
                        <p class="font-semibold text-slate-900 truncate">{{ $affiliate->name }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ $affiliate->email }}</p>
                        <p class="mt-1 text-[11px] text-slate-400">Kode <span class="font-mono font-semibold text-blue-700">{{ $affiliate->affiliate_code }}</span> · {{ number_format($affiliate->clicks_count ?? 0, 0, ',', '.') }} klik</p>
                    </a>
                    @if($affiliate->status === 'pending')
                    <x-admin.badge color="yellow">Pending</x-admin.badge>
                    @elseif($affiliate->status === 'approved')
                    <x-admin.badge color="green">Approved</x-admin.badge>
                    @else
                    <x-admin.badge color="slate">Rejected</x-admin.badge>
                    @endif
                </div>
                <div class="mt-2 flex items-center justify-between text-xs">
                    <span class="text-slate-500">Saldo komisi</span>
                    <span class="font-bold text-slate-900">Rp {{ number_format($affiliate->balance, 0, ',', '.') }}</span>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-2">
                    @if($affiliate->status === 'pending')
                    <form action="{{ route('admin.affiliates.approve', $affiliate->id) }}" method="POST">
                        @csrf
                        <x-admin.button type="submit" size="sm" icon="fa-solid fa-check" class="w-full justify-center">Approve</x-admin.button>
                    </form>
                    <form action="{{ route('admin.affiliates.reject', $affiliate->id) }}" method="POST" data-confirm="Apakah Anda yakin ingin menolak partner ini?" data-confirm-danger>
                        @csrf
                        <x-admin.button type="submit" variant="danger" size="sm" icon="fa-solid fa-xmark" class="w-full justify-center">Reject</x-admin.button>
                    </form>
                    @elseif($affiliate->status === 'approved')
                    <x-admin.button type="button" size="sm" icon="fa-solid fa-plus" class="w-full justify-center" @click="openCommission({{ $affiliate->id }}, '{{ addslashes($affiliate->name) }}')">Komisi</x-admin.button>
                    <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-eye" class="w-full justify-center" :href="route('admin.affiliates.show', $affiliate->id)">Detail</x-admin.button>
                    @else
                    <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-eye" class="col-span-2 w-full justify-center" :href="route('admin.affiliates.show', $affiliate->id)">Detail</x-admin.button>
                    @endif
                </div>
            </div>
            @empty
            <div class="px-4 py-12 text-center text-sm text-slate-500">
                {{ request('q') || request('status') ? 'Tidak ada partner yang cocok dengan filter.' : 'Belum ada partner affiliate terdaftar.' }}
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($affiliates->hasPages())
        <div class="px-4 py-3 border-t border-slate-200">
            {{ $affiliates->links('pagination::tailwind') }}
        </div>
        @endif
    </x-admin.card>

    {{-- Modal Tambah Partner Baru --}}
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="addModalOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

        <div class="min-h-full p-4 flex items-center justify-center">
            <div x-show="addModalOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                @click.away="addModalOpen = false"
                class="relative w-full max-w-lg bg-white rounded-2xl shadow-xl border border-slate-200 p-6 z-10">

                <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i class="fa-solid fa-user-plus text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-slate-900">Tambah Partner Baru</h3>
                            <p class="text-xs text-slate-400">Buat akun affiliate secara manual.</p>
                        </div>
                    </div>
                    <button type="button" @click="addModalOpen = false" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <form action="{{ route('admin.affiliates.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <x-admin.label for="addPartnerName" required>Nama Lengkap</x-admin.label>
                        <x-admin.input name="name" id="addPartnerName" required placeholder="Contoh: Budi Santoso" />
                    </div>

                    <div>
                        <x-admin.label for="addPartnerEmail" required>Email</x-admin.label>
                        <x-admin.input type="email" name="email" id="addPartnerEmail" required placeholder="budi@example.com" />
                    </div>

                    <div>
                        <x-admin.label for="addPartnerPassword" required>Password</x-admin.label>
                        <x-admin.input type="password" name="password" id="addPartnerPassword" required minlength="8" placeholder="Minimal 8 karakter" />
                    </div>

                    <div>
                        <x-admin.label for="addPartnerStatus" required>Status Awal</x-admin.label>
                        <x-admin.select name="status" id="addPartnerStatus">
                            <option value="approved">Approved (Langsung Aktif)</option>
                            <option value="pending">Pending (Perlu Review)</option>
                        </x-admin.select>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                        <x-admin.button type="button" variant="secondary" @click="addModalOpen = false">Batal</x-admin.button>
                        <x-admin.button type="submit" icon="fa-solid fa-floppy-disk">Simpan Partner</x-admin.button>
                    </div>
                </form>
            </div>
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
                    <span class="font-bold text-blue-900 truncate max-w-[200px]" x-text="selectedAffiliateName"></span>
                </div>

                <form :action="'/admin/affiliates/' + selectedAffiliateId + '/commission'" method="POST" class="space-y-4">
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
