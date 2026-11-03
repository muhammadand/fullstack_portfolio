@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Buat Blog Baru" subtitle="Tulis dan publikasikan artikel baru." :back="route('blogs.index')" />

@include('blogs.partials.form', ['blog' => null])
@endsection
