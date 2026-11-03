@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Tambah Review Card Baru" subtitle="Buat unit kartu/stiker QR secara satuan dengan parameter kustom." :back="route('admin.review_cards.index')" />

@include('admin.review_cards.form', [
    'card' => null,
    'defaultSerial' => $defaultSerial ?? '',
    'defaultSlug' => $defaultSlug ?? '',
    'defaultPin' => $defaultPin ?? '',
])
@endsection
