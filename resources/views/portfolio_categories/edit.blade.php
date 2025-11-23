@extends('layouts.admin.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">
    <h2 class="text-3xl font-bold mb-6 gradient-text">Edit Kategori Portfolio</h2>

    <form action="{{ route('portfolio-categories.update', $item->id) }}" method="POST"
          class="space-y-6 bg-white p-8 rounded-2xl shadow-md">
        @csrf
        @method('PUT')
        @include('portfolio_categories.form')

        <div class="flex justify-end gap-3">
            <a href="{{ route('portfolio-categories.index') }}"
               class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition">
               Batal
            </a>
            <button type="submit"
                    class="bg-gradient-to-r from-purple-600 to-purple-700 text-white px-5 py-2 rounded-lg font-medium shadow hover:shadow-lg transition">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
