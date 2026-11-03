@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Edit Kategori Portfolio" :subtitle="$item->name" :back="route('portfolio-categories.index')" />

@if (session('success'))
<x-admin.alert type="success">{{ session('success') }}</x-admin.alert>
@endif

@include('portfolio_categories.form', ['item' => $item])
@endsection
