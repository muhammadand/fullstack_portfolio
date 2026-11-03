@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Edit Produk Digital" :subtitle="$digitalProduct->name" :back="route('admin.digital_products.index')" />

@include('admin.digital_products.form', ['digitalProduct' => $digitalProduct])
@endsection
