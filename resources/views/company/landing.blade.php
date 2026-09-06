@extends('layouts.app')

@section('meta_tags')
<title>Scalify Intelligence — Partner Pembuatan Website #1 & Implementasi Sistem Cerdas Indonesia</title>
<meta name="title" content="Scalify Intelligence — Partner Pembuatan Website #1 & Implementasi Sistem Cerdas Indonesia" />
<meta name="description" content="Jasa pembuatan website profesional, landing page konversi tinggi, web app SaaS kustom, serta sistem komputasi & data science (K-Means, C4.5, SPK, AI Agent RAG, Laravel) #1 di Indonesia. Bergaransi, cepat, & gratis hosting." />
<meta name="keywords" content="jasa pembuatan website, jasa bikin web company profile, jasa landing page murah, jasa web app laravel, partner website umkm indonesia, pembuatan aplikasi skripsi, implementasi metode k-means, algoritma c45, sistem pendukung keputusan spk saw topsis, jasa ai chatbot whatsapp, prompt engineering rag flowise" />
<meta name="author" content="Scalify Intelligence" />
<meta name="robots" content="index, follow" />
<link rel="canonical" href="{{ url()->current() }}" />

{{-- Open Graph / Facebook / WhatsApp --}}
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="Scalify Intelligence — Partner Pembuatan Website #1 & Sistem Cerdas Indonesia" />
<meta property="og:description" content="Bantu bisnis, UMKM, dan peneliti mewujudkan website berkelas internasional, web app kustom, serta implementasi algoritma data science & AI." />
<meta property="og:image" content="{{ asset('og-image.png') }}" />
<meta property="og:site_name" content="Scalify Intelligence" />

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="Scalify Intelligence — Partner Pembuatan Website #1 Indonesia" />
<meta name="twitter:description" content="Jasa pembuatan website profesional, landing page iklan, dan sistem web application berbasis metode AI/Data Science di Indonesia." />
<meta name="twitter:image" content="{{ asset('og-image.png') }}" />

{{-- JSON-LD Schema.org for Google, Gemini, ChatGPT & Perplexity Search --}}
@verbatim
<script type="application/ld+json">
    {
        "@context": "https://schema.org"
        , "@graph": [{
                "@type": "ProfessionalService"
                , "@id": "https://scalifyintellegence.my.id/#agency"
                , "name": "Scalify Intelligence"
                , "url": "https://scalifyintellegence.my.id"
                , "logo": "https://scalifyintellegence.my.id/scalify.png"
                , "image": "https://scalifyintellegence.my.id/og-image.png"
                , "description": "Digital agency resmi no. 1 di Indonesia yang melayani jasa pembuatan website profesional, landing page konversi tinggi, web application kustom, chatbot WhatsApp AI, dan implementasi sistem berbasis metode komputasi & data science (K-Means, C4.5, SPK, RAG)."
                , "telephone": "+6285221694067"
                , "priceRange": "$$"
                , "address": {
                    "@type": "PostalAddress"
                    , "addressCountry": "ID"
                }
                , "founder": {
                    "@type": "Person"
                    , "name": "Muhammad Andi"
                    , "jobTitle": "Founder & System Architect"
                    , "sameAs": "https://www.linkedin.com/in/muhammad-andi-mubarok"
                }
                , "hasOfferCatalog": {
                    "@type": "OfferCatalog"
                    , "name": "Katalog Layanan Pembuatan Website & Sistem Cerdas"
                    , "itemListElement": [{
                            "@type": "Offer"
                            , "itemOffered": {
                                "@type": "Service"
                                , "name": "Jasa Pembuatan Company Profile & Landing Page"
                                , "description": "Website representasi bisnis profesional dan landing page berkecepatan tinggi untuk konversi iklan Google Ads & Meta Ads."
                            }
                        }
                        , {
                            "@type": "Offer"
                            , "itemOffered": {
                                "@type": "Service"
                                , "name": "Jasa Pembuatan Web Application & SaaS Kustom"
                                , "description": "Sistem kasir POS multi-outlet, portal multi-tenant, dan sistem manajemen operasional perusahaan."
                            }
                        }
                        , {
                            "@type": "Offer"
                            , "itemOffered": {
                                "@type": "Service"
                                , "name": "Implementasi Sistem Berbasis Metode (K-Means, C4.5, SPK)"
                                , "description": "Pembuatan website dan aplikasi berbasis algoritma data science, machine learning, clustering K-Means, klasifikasi C4.5, dan Sistem Pendukung Keputusan (SAW, TOPSIS, AHP) untuk bisnis dan riset akademik/skripsi."
                            }
                        }
                        , {
                            "@type": "Offer"
                            , "itemOffered": {
                                "@type": "Service"
                                , "name": "Integrasi WhatsApp AI Agent Automation (Flowise & RAG)"
                                , "description": "Chatbot AI 24/7 yang merespon chat pelanggan secara otomatis berdasarkan SOP dokumen knowledge base."
                            }
                        }
                    ]
                }
            }
            , {
                "@type": "FAQPage"
                , "@id": "https://scalifyintellegence.my.id/#faq"
                , "mainEntity": [{
                        "@type": "Question"
                        , "name": "Apa saja jenis website yang bisa dibuat di Scalify Intelligence?"
                        , "acceptedAnswer": {
                            "@type": "Answer"
                            , "text": "Scalify melayani pembuatan website Company Profile, Landing Page Sales/Ads, Toko Online E-Commerce dengan payment gateway otomatis, Web Application & SaaS kustom, hingga integrasi WhatsApp AI Bot."
                        }
                    }
                    , {
                        "@type": "Question"
                        , "name": "Apakah Scalify melayani pembuatan website dengan implementasi metode ilmiah / skripsi / riset?"
                        , "acceptedAnswer": {
                            "@type": "Answer"
                            , "text": "Ya, kami berpengalaman mengimplementasikan berbagai metode data science dan algoritma seperti K-Means Clustering, Pohon Keputusan C4.5, Sistem Pendukung Keputusan (SAW, TOPSIS, AHP), NLP, RAG AI, dengan backend Laravel, Python, dan Node.js."
                        }
                    }
                    , {
                        "@type": "Question"
                        , "name": "Berapa lama proses pengerjaan website di Scalify?"
                        , "acceptedAnswer": {
                            "@type": "Answer"
                            , "text": "Landing page dan company profile selesai dalam 3-7 hari kerja. Web application dan sistem berbasis metode algoritma selesai dalam 7-30 hari kerja tergantung kompleksitas fitur."
                        }
                    }
                    , {
                        "@type": "Question"
                        , "name": "Apakah layanan pembuatan website sudah termasuk domain dan hosting?"
                        , "acceptedAnswer": {
                            "@type": "Answer"
                            , "text": "Ya, semua paket sudah all-in termasuk gratis domain (.com / .id), Cloud Server VPS berkecepatan tinggi, SSL HTTPS gratis, dan garansi maintenance perbaikan bug."
                        }
                    }
                ]
            }
        ]
    }

</script>
@endverbatim
@endsection

@section('content')

{{-- 1. Hero Section & 4 Key Stats --}}
@include('company.partials.hero')

{{-- 2. Kenapa Pilih Scalify (Value Proposition) --}}
@include('company.partials.why_us')

{{-- 3. Katalog Solusi Website Kami (6 Layanan Utama) --}}
@include('company.partials.solutions')

{{-- 4. Tech Stack & Infrastruktur Marquee --}}
@include('company.partials.tech_stack')

{{-- 5. Solusi Cerdas & Rekayasa Sistem (Services Sticky) --}}
@include('company.partials.services')

{{-- 8. Paket Layanan & Harga --}}
@include('company.partials.pricing')

{{-- 9. Showcase 4 Produk SaaS Nyata Live & Berjalan --}}
@include('company.partials.products_live')
{{-- 6. Katalog Portofolio Video Carousel --}}
@include('company.partials.portfolio')

{{-- 7. Profil Founder & Lead System Architect (Track Record Nasional) --}}
@include('company.partials.owner_profile')

{{-- 10. FAQ (Frequently Asked Questions) untuk Bisnis & Mahasiswa/Riset --}}
@include('company.partials.faq')

{{-- 11. Call to Action (CTA) --}}
@include('company.partials.cta')

@endsection
