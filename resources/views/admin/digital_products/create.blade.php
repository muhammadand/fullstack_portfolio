@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Tambah Produk Digital" subtitle="Daftarkan produk baru yang terhubung ke Lynk.id untuk para affiliate." :back="route('admin.digital_products.index')" />

@include('admin.digital_products.form', ['digitalProduct' => null])
@endsection
