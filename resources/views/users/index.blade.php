@extends('layouts.admin.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">
    {{-- ✅ Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold text-slate-800">Daftar Users</h2>

        <div class="flex gap-2">
            {{-- ➕ Tambah --}}
            <a href="{{ route('users.create') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg font-medium shadow hover:bg-blue-700 transition">
                Create
            </a>
        </div>
    </div>

    {{-- ✅ Alert --}}
    @if(session('success'))
    <div class="mb-4 p-4 rounded-lg bg-green-100 border border-green-300 text-green-800">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-4 p-4 rounded-lg bg-red-100 border border-red-300 text-red-800">
        {{ session('error') }}
    </div>
    @endif

    {{-- ✅ Table --}}
    <div class="overflow-x-auto bg-white rounded-xl shadow-sm border border-slate-200">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-slate-50 text-slate-700 border-b border-slate-200">
                <tr>
                    <th class="py-3 px-4 font-semibold">#</th>
                    <th class="py-3 px-4 font-semibold">Nama</th>
                    <th class="py-3 px-4 font-semibold">Email</th>
                    <th class="py-3 px-4 font-semibold">Role</th>
                    <th class="py-3 px-4 font-semibold">Status</th>
                    <th class="py-3 px-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $i => $item)
                <tr class="border-b hover:bg-slate-50 transition">
                    <td class="py-3 px-4">{{ $loop->iteration }}</td>
                    <td class="py-3 px-4 font-medium text-slate-900">
                        <div class="flex items-center gap-3">
                            @if($item->profile_photo)
                            <img src="{{ asset('storage/' . $item->profile_photo) }}" alt="avatar" class="w-8 h-8 rounded-full object-cover">
                            @else
                            <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold">
                                {{ substr($item->name, 0, 1) }}
                            </div>
                            @endif
                            {{ $item->name }}
                        </div>
                    </td>
                    <td class="py-3 px-4">{{ $item->email }}</td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded text-xs font-semibold bg-slate-100 text-slate-700 uppercase">
                            {{ str_replace('_', ' ', $item->role) }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                                {{ $item->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center flex gap-2 justify-center">
                        <a href="{{ route('users.edit', $item->id) }}" class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-xs font-semibold transition">
                            Edit
                        </a>
                        @if(auth()->id() !== $item->id)
                        <form action="{{ route('users.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs font-semibold transition">
                                Hapus
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-6 text-center text-slate-500 italic">
                        Belum ada user.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
