@extends('layouts.admin.app')

@section('content')
<x-admin.page-header :title="'Edit Review Card: ' . $card->serial_number" subtitle="Perbarui konfigurasi URL Google Review atau status aktivasi kartu." :back="route('admin.review_cards.index')" />

@include('admin.review_cards.form', ['card' => $card])
@endsection
