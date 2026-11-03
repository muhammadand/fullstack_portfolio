@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Tambah Kategori Portfolio" subtitle="Buat kategori baru untuk mengelompokkan portfolio." :back="route('portfolio-categories.index')" />

@include('portfolio_categories.form', ['item' => null])
@endsection
