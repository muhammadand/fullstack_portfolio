@extends('layouts.admin.app')

@section('content')
<br><br><br><br><br>

<div class="max-w-5xl mx-auto px-6 py-10">
    <h2 class="text-3xl font-bold gradient-text mb-6">Edit Portfolio: {{ $item->title }}</h2>

    <form action="{{ route('portfolio.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Sama persis seperti form create --}}
        @include('portfolio._form', ['item' => $item])
        
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('portfolio.index') }}" class="bg-gray-300 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-400 transition">Batal</a>
            <button type="submit" class="bg-yellow-500 text-white px-5 py-2 rounded-lg hover:bg-yellow-600 transition">Perbarui</button>
        </div>
    </form>
</div>
@endsection
