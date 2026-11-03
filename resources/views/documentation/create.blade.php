@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Tambah Foto Dokumentasi" subtitle="Upload foto dokumentasi kegiatan Sobat Scalify." :back="route('documentation.index')" />

@include('documentation.form', ['documentation' => null])
@endsection
