@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Edit Foto Dokumentasi" :subtitle="$documentation->title" :back="route('documentation.index')" />

@include('documentation.form', ['documentation' => $documentation])
@endsection
