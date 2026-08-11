@extends('layouts.admin.app')

@section('content')
<div class="px-6 py-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Client Proposals</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data klien untuk landing page dan proposal penawaran.</p>
        </div>
        <a href="{{ route('admin.client_proposals.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Klien Baru
        </a>
    </div>

    @if(session('success'))
    <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Brand Klien</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kontak WA</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Harga Project</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($proposals as $p)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $p->brand_name }}</div>
                            <div class="text-xs text-slate-500">{{ $p->client_name ?? '-' }}</div>
                            <div class="text-xs text-blue-500 mt-1">/proposal/{{ $p->slug }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $p->category ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $p->category ? $p->category->name : 'Tanpa Kategori' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-slate-800">{{ $p->wa_number }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-emerald-600">Rp {{ number_format($p->project_price, 0, ',', '.') }}</div>
                            <div class="text-xs text-slate-500">+ Domain: Rp {{ number_format($p->domain_price, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('landing.dynamic', $p->slug) }}" target="_blank" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium rounded-lg transition-colors" title="Lihat Landing Page">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('proposal.dynamic', $p->slug) }}" target="_blank" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium rounded-lg transition-colors" title="Lihat Proposal">
                                <i class="fa-solid fa-file-invoice"></i>
                            </a>
                            <a href="{{ route('admin.client_proposals.edit', $p->id) }}" class="px-3 py-1.5 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 text-xs font-medium rounded-lg transition-colors" title="Edit Data">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.client_proposals.destroy', $p->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data klien ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded-lg transition-colors" title="Hapus Data">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                            Belum ada data client proposal yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
