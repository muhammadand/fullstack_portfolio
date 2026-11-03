@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Edit Blog" :subtitle="$blog->title" :back="route('blogs.index')">
    <x-admin.button variant="secondary" icon="fa-solid fa-eye" :href="route('blogs.show', $blog)">Lihat</x-admin.button>
</x-admin.page-header>

@if (session('success'))
<x-admin.alert type="success">{{ session('success') }}</x-admin.alert>
@endif

@include('blogs.partials.form', ['blog' => $blog])
@endsection
