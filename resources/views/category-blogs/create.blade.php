@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Tambah Kategori Blog" subtitle="Buat kategori baru untuk mengelompokkan artikel blog." :back="route('blog-categories.index')" />

@include('category-blogs.form', ['category' => null])
@endsection
