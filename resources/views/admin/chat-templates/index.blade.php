@extends('layouts.admin.app')

@section('content')
<div class="px-4 lg:px-6 py-6 lg:py-8">
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Template Chat WhatsApp</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola daftar template pesan untuk penawaran klien via WhatsApp.</p>
        </div>
        <button type="button" onclick="openTemplateModal()" class="w-full sm:w-auto px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm flex justify-center items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Template
        </button>
    </div>

    @if(session('success'))
    <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
        <p class="flex items-center gap-2"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</p>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
        <ul class="list-disc ml-5 text-sm">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($templates as $t)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-bold text-slate-800">{{ $t->name }}</h3>
                <div class="flex gap-2">
                    <button type="button" onclick="openTemplateModal({{ $t->id }}, '{{ addslashes($t->name) }}', '{{ base64_encode($t->content) }}')" class="w-8 h-8 rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 flex items-center justify-center transition-colors" title="Edit Template">
                        <i class="fa-solid fa-pen text-xs"></i>
                    </button>
                    <form action="{{ route('admin.chat_templates.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus template ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition-colors" title="Hapus Template">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="p-5 flex-grow">
                <div class="bg-green-50/50 rounded-xl p-4 border border-green-100 relative">
                    <div class="absolute -top-3 -right-3 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <p class="text-sm text-slate-600 whitespace-pre-wrap font-mono">{{ Str::limit($t->content, 150) }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400 text-2xl">
                <i class="fa-regular fa-message"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-700 mb-2">Belum Ada Template</h3>
            <p class="text-slate-500 mb-6">Anda belum membuat satupun template pesan WhatsApp.</p>
            <button type="button" onclick="openTemplateModal()" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-colors shadow-sm inline-flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Buat Template Pertama
            </button>
        </div>
        @endforelse
    </div>
</div>

<!-- Template Form Modal -->
<div id="templateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-white w-full max-w-lg p-6 rounded-3xl shadow-2xl transform scale-95 transition-transform duration-300 mx-4" id="templateModalContent">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-slate-800" id="modalTitle">Tambah Template Baru</h3>
            <button type="button" onclick="closeTemplateModal()" class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="templateForm" action="{{ route('admin.chat_templates.store') }}" method="POST">
            @csrf
            <div id="methodField"></div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Template</label>
                <input type="text" name="name" id="templateName" required class="w-full bg-slate-50 border-2 border-slate-200 text-slate-800 rounded-xl py-3 px-4 focus:outline-none focus:border-blue-400 transition-colors" placeholder="Contoh: Penawaran Pertama">
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-2">Isi Pesan</label>
                <textarea name="content" id="templateContent" rows="6" required class="w-full bg-slate-50 border-2 border-slate-200 text-slate-800 rounded-xl py-3 px-4 focus:outline-none focus:border-blue-400 transition-colors placeholder-slate-400 leading-relaxed font-mono text-sm" placeholder="Halo {nama_bisnis}, kami dari..."></textarea>
                <p class="text-xs text-slate-500 mt-2">Gunakan placeholder seperti <code class="bg-slate-100 px-1 py-0.5 rounded text-slate-700">{nama_bisnis}</code>, <code class="bg-slate-100 px-1 py-0.5 rounded text-slate-700">{link_proposal}</code> jika perlu.</p>
            </div>

            <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-sm">
                Simpan Template
            </button>
        </form>
    </div>
</div>

<script>
    function openTemplateModal(id = null, name = '', contentB64 = '') {
        const modal = document.getElementById('templateModal');
        const modalContent = document.getElementById('templateModalContent');
        const form = document.getElementById('templateForm');
        const title = document.getElementById('modalTitle');
        const nameInput = document.getElementById('templateName');
        const contentInput = document.getElementById('templateContent');
        const methodField = document.getElementById('methodField');

        if (id) {
            title.textContent = 'Edit Template';
            form.action = `/admin/chat-templates/${id}`;
            methodField.innerHTML = '@method("PUT")';
            nameInput.value = name;
            contentInput.value = decodeURIComponent(escape(window.atob(contentB64)));
        } else {
            title.textContent = 'Tambah Template Baru';
            form.action = "{{ route('admin.chat_templates.store') }}";
            methodField.innerHTML = '';
            nameInput.value = '';
            contentInput.value = '';
        }

        modal.classList.remove('opacity-0', 'pointer-events-none');
        modalContent.classList.remove('scale-95');
        modalContent.classList.add('scale-100');
    }

    function closeTemplateModal() {
        const modal = document.getElementById('templateModal');
        const modalContent = document.getElementById('templateModalContent');

        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 150);
    }

</script>
@endsection
