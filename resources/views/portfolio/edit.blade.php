@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Edit Portfolio" :subtitle="$item->title" :back="route('portfolio.index')" />

@include('portfolio.partials.form', ['item' => $item])
@endsection
