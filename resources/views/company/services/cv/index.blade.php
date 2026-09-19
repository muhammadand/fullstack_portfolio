@extends('layouts.app')

@section('meta_tags')
<title>Template CV Profesional Standar HRD & AI CV Assistant — Scalify Intelligence</title>
<meta name="title" content="Template CV Profesional Standar HRD & AI CV Assistant — Scalify Intelligence" />
<meta name="description" content="Buat CV profesional siap kerja dan lolos seleksi HRD/ATS dalam hitungan detik. Didukung oleh asisten AI Google Gemini, live preview 2-kolom, upload foto, dan cetak PDF A4 presisi." />
<meta name="keywords" content="template cv profesional, cv ats friendly indonesia, ai cv maker, generator resume ai, contoh cv lamaran kerja, template cv hrd, buat cv pdf otomatis, scalify intelligence" />
<meta name="author" content="Scalify Intelligence" />
<meta name="robots" content="index, follow" />
<link rel="canonical" href="{{ url()->current() }}" />

{{-- Open Graph / Facebook / WhatsApp --}}
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="Template CV Profesional Standar HRD & AI CV Assistant — Scalify Intelligence" />
<meta property="og:description" content="Susun CV berstandar HRD top tier dengan bantuan AI Google Gemini. Live preview, upload foto, formula STAR, dan cetak PDF A4 instan." />
<meta property="og:image" content="{{ asset('og-image.png') }}" />
<meta property="og:site_name" content="Scalify Intelligence" />

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="Template CV Profesional Standar HRD & AI CV Assistant" />
<meta name="twitter:description" content="Susun CV berstandar HRD top tier dengan bantuan AI Google Gemini. Live preview, upload foto, dan cetak PDF A4 instan." />
<meta name="twitter:image" content="{{ asset('og-image.png') }}" />

{{-- JSON-LD Schema --}}
@verbatim
<script type="application/ld+json">
    {
        "@context": "https://schema.org"
        , "@type": "WebApplication"
        , "name": "Scalify AI CV Builder & Professional Template"
        , "url": "https://scalifyintellegence.my.id/layanan/template-cv"
        , "applicationCategory": "BusinessApplication"
        , "operatingSystem": "All"
        , "offers": {
            "@type": "Offer"
            , "price": "0"
            , "priceCurrency": "IDR"
        }
        , "description": "Platform pembuatan CV profesional interaktif berbasis AI Gemini dengan template 2-kolom standar HRD dan export PDF A4."
    }

</script>
@endverbatim
@endsection

@section('content')
<div class="bg-[#090d29] text-slate-100 min-h-screen font-sans selection:bg-cyan-500 selection:text-white pb-20 lg:pb-0">

    {{-- 1. Hero Section --}}
    @include('company.services.cv.partials.hero')

    {{-- 2. Interactive Conversational AI Chat & Live 2-Column CV Builder --}}
    @include('company.services.cv.partials.ai_builder')

    {{-- 3. Kenapa Format Ini Auto Dilirik HRD (ATS & Visual Hierarchy) --}}
    @include('company.services.cv.partials.why_ats')

    {{-- 4. Showcase Template & Variasi Desain --}}
    @include('company.services.cv.partials.templates_showcase')

    {{-- 5. Paket Jasa Revamp CV & Konsultasi Karir 1-on-1 --}}
    @include('company.services.cv.partials.pricing')

    {{-- 6. FAQ Seputar CV & Tips Melamar Kerja --}}
    @include('company.services.cv.partials.faq')

    {{-- 7. Call To Action WhatsApp --}}
    @include('company.services.cv.partials.cta')

</div>
@endsection
