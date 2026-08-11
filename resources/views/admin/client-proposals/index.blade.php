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
                                <button type="button" data-id="{{ $p->id }}" data-brand="{{ $p->brand_name }}" data-phone="{{ $p->wa_number }}" data-link="{{ route('landing.dynamic', $p->slug) }}" data-template="{{ $p->wa_template ?? "Halo {nama_bisnis},\n\nKami dari tim Scalify ingin menawarkan penawaran spesial untuk pembuatan website bisnis Anda.\n\nBerikut adalah preview proposal dan draft website Anda:\n{link_proposal}\n\nApakah ada waktu untuk berdiskusi sebentar?" }}" onclick="openWaModal(this)" class="flex items-center gap-1 px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 text-xs font-medium rounded-lg transition-colors" title="Kirim Penawaran via WA">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    <span>WA</span>
                                </button>
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

<!-- WA Template Modal -->
<div id="waModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-white w-full max-w-lg p-6 rounded-3xl shadow-2xl transform scale-95 transition-transform duration-300 mx-4" id="waModalContent">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-slate-800">Template Pesan WhatsApp</h3>
            <button type="button" onclick="closeWaModal()" class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="mb-4 p-3 bg-green-50 border border-green-100 rounded-xl text-sm flex gap-3 items-center">
            <div class="w-10 h-10 rounded-full bg-green-200 flex items-center justify-center text-green-700 shrink-0">
                <i class="fa-brands fa-whatsapp text-xl"></i>
            </div>
            <div>
                <span class="block font-semibold text-green-800" id="waBrandNameDisplay"></span>
                <span class="block text-green-700 font-mono text-xs" id="waPhoneDisplay"></span>
            </div>
        </div>

        <form id="waForm" action="" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Template Tersimpan (Opsional)</label>
                <select id="savedTemplateSelect" class="w-full bg-slate-50 border-2 border-slate-200 text-slate-800 rounded-xl py-3 px-4 focus:outline-none focus:border-green-400 transition-colors appearance-none" onchange="applyTemplate()">
                    <option value="">-- Gunakan pesan saat ini --</option>
                    @foreach($chatTemplates as $ct)
                    <option value="{{ base64_encode($ct->content) }}">{{ $ct->name }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center px-2 text-slate-500 mt-8">
                    <i class="fa-solid fa-chevron-down text-sm"></i>
                </div>
            </div>

            <div class="mb-5 relative">
                <label class="block text-sm font-medium text-slate-700 mb-2">Isi Pesan Penawaran</label>
                <textarea name="wa_template" id="waTemplateInput" rows="6" required class="w-full bg-slate-50 border-2 border-slate-200 text-slate-800 rounded-xl py-3 px-4 focus:outline-none focus:border-green-400 transition-colors placeholder-slate-400 leading-relaxed"></textarea>
                <p class="text-xs text-slate-500 mt-2"><i class="fa-solid fa-circle-info mr-1"></i> Anda dapat mengedit template ini sebelum mengirim. Menyimpan template hanya berlaku untuk klien ini.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" class="w-full sm:w-1/3 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-all shadow-sm">
                    Simpan Saja
                </button>
                <button type="button" onclick="kirimWaLangsung()" class="w-full sm:w-2/3 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl transition-all shadow-sm shadow-green-500/30 flex justify-center items-center gap-2">
                    <i class="fa-brands fa-whatsapp"></i> Kirim Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentWaPhone = '';
    let currentWaBrand = '';
    let currentWaLink = '';

    function openWaModal(button) {
        const modal = document.getElementById('waModal');
        const content = document.getElementById('waModalContent');
        const form = document.getElementById('waForm');

        const id = button.getAttribute('data-id');
        const brand = button.getAttribute('data-brand');
        const phone = button.getAttribute('data-phone');
        const link = button.getAttribute('data-link');
        const template = button.getAttribute('data-template');

        currentWaPhone = phone;
        currentWaBrand = brand;
        currentWaLink = link;

        document.getElementById('waBrandNameDisplay').textContent = brand;
        document.getElementById('waPhoneDisplay').textContent = phone || 'Nomor WA belum diatur';
        document.getElementById('waTemplateInput').value = template;
        document.getElementById('savedTemplateSelect').value = '';

        form.action = `/admin/client-proposals/${id}/wa-template`;

        modal.classList.remove('opacity-0', 'pointer-events-none');
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }

    function closeWaModal() {
        const modal = document.getElementById('waModal');
        const content = document.getElementById('waModalContent');

        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 150);
    }

    function kirimWaLangsung() {
        const text = document.getElementById('waTemplateInput').value;
        const phone = currentWaPhone;

        if (!phone) {
            alert('Nomor WhatsApp belum diatur untuk klien ini. Silakan edit data klien terlebih dahulu.');
            return;
        }

        // Format number to replace leading 0 or +62 with 62
        let formattedPhone = phone.replace(/[^0-9]/g, '');
        if (formattedPhone.startsWith('0')) {
            formattedPhone = '62' + formattedPhone.substring(1);
        }

        const waUrl = `https://wa.me/${formattedPhone}?text=${encodeURIComponent(text)}`;
        window.open(waUrl, '_blank');
    }

    function applyTemplate() {
        const select = document.getElementById('savedTemplateSelect');
        const input = document.getElementById('waTemplateInput');

        if (select.value) {
            let decoded = decodeURIComponent(escape(window.atob(select.value)));

            // Auto replace placeholder {nama_bisnis} and {link_proposal}
            if (currentWaBrand) {
                decoded = decoded.replace(/\{nama_bisnis\}/g, currentWaBrand);
            }
            if (currentWaLink) {
                decoded = decoded.replace(/\{link_proposal\}/g, currentWaLink);
            }

            input.value = decoded;
        }
    }

</script>
@endsection
