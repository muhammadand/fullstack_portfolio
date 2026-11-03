@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Tambah Portfolio" subtitle="Showcase karya terbaik Anda." :back="route('portfolio.index')" />

@include('portfolio.partials.form', ['item' => null])
@endsection
