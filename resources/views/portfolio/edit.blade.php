@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Edit Portfolio" :subtitle="$item->title" :back="route('portfolio.index')">
    <x-admin.button variant="secondary" icon="fa-solid fa-eye" :href="route('portfolio.read', $item->slug)" target="_blank">Lihat</x-admin.button>
</x-admin.page-header>

@if (session('success'))
<x-admin.alert type="success">{{ session('success') }}</x-admin.alert>
@endif

@include('portfolio.partials.form', ['item' => $item])
@endsection
