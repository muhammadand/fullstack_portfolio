@extends('layouts.admin.app')

@section('content')
<div class="px-4 lg:px-6 py-6 lg:py-8">
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Client Proposals</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data klien untuk landing page dan proposal penawaran.</p>
        </div>
        <a href="{{ route('admin.client_proposals.create') }}" class="w-full sm:w-auto px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm flex justify-center items-center gap-2">
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
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('landing.dynamic', $p->slug) }}" target="_blank" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium rounded-lg transition-colors" title="Lihat Landing Page">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('proposal.dynamic', $p->slug) }}" target="_blank" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium rounded-lg transition-colors" title="Lihat Proposal">
                                    <i class="fa-solid fa-file-invoice"></i>
                                </a>
                                <a href="{{ route('admin.client_proposals.edit', $p->id) }}" class="px-3 py-1.5 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 text-xs font-medium rounded-lg transition-colors" title="Edit Data">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <div class="relative inline-block">
                                    <select onchange="kirimWaLangsung(this, '{{ $p->wa_number }}', '{{ $p->brand_name }}', '{{ route('landing.dynamic', $p->slug) }}', '{{ route('proposal.dynamic', $p->slug) }}')" class="appearance-none pl-7 pr-6 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 text-xs font-medium rounded-lg transition-colors cursor-pointer outline-none">
                                        <option value="" disabled selected>Kirim WA</option>
                                        @foreach($chatTemplates as $ct)
                                        <option value="{{ base64_encode($ct->content) }}">{{ $ct->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2 text-green-700">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </div>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-green-700">
                                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                    </div>
                                </div>
                                <form action="{{ route('admin.client_proposals.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data klien ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded-lg transition-colors" title="Hapus Data">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            Belum ada data client proposal yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function kirimWaLangsung(selectElement, phone, brandName, linkLandingPage, linkProposal) {
        if (!selectElement.value) return;

        if (!phone) {
            alert('Nomor WhatsApp belum diatur untuk klien ini. Silakan edit data klien terlebih dahulu.');
            selectElement.value = "";
            return;
        }

        // Format number to replace leading 0 or +62 with 62
        let formattedPhone = phone.replace(/[^0-9]/g, '');
        if (formattedPhone.startsWith('0')) {
            formattedPhone = '62' + formattedPhone.substring(1);
        }

        // Decode template text
        let text = decodeURIComponent(escape(window.atob(selectElement.value)));

        // Replace placeholders
        if (brandName) {
            text = text.replace(/\{nama_bisnis\}/g, brandName);
        }
        if (linkLandingPage) {
            text = text.replace(/\{link_landing_page\}/g, linkLandingPage);
        }
        if (linkProposal) {
            text = text.replace(/\{link_proposal\}/g, linkProposal);
        }

        // Open WA Link
        const waUrl = `https://api.whatsapp.com/send?phone=${formattedPhone}&text=${encodeURIComponent(text)}`;

        // Deteksi jika dibuka via HP (Mobile) agar langsung buka aplikasi tanpa diblokir browser
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            window.location.href = waUrl;
        } else {
            window.open(waUrl, '_blank');
        }

        // Reset dropdown back to default
        selectElement.value = "";
    }

</script>
@endsection
