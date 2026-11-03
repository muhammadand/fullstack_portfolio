@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Edit Kategori Blog" :subtitle="$category->name" :back="route('blog-categories.index')" />

@if (session('success'))
<x-admin.alert type="success">{{ session('success') }}</x-admin.alert>
@endif

@include('category-blogs.form', ['category' => $category])
@endsection
