<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scalify Admin — Dashboard</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('scalify.png') }}">
    {{-- PWA admin: di iPhone, push hanya jalan bila panel dipasang ke Home Screen. --}}
    <link rel="manifest" href="/manifest-admin.json">
    <meta name="theme-color" content="#0F172A">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Scalify Admin">
    <link rel="apple-touch-icon" href="/images/icons/icon-192x192.png">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'midnight': '#0F172A'
                        , 'midnight-800': '#1E293B'
                        , 'midnight-700': '#253044'
                        , 'midnight-600': '#334155'
                        , 'midnight-accent': '#3B82F6'
                    , }
                    , fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    , }
                }
            }
        }

    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @livewireStyles
</head>

<body class="bg-slate-50 font-sans h-screen overflow-hidden">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen relative w-full overflow-hidden">

        <!-- Sidebar: hanya desktop. Di HP navigasi pakai bottom nav + halaman Menu. -->
        <div class="hidden lg:block relative z-50 h-screen">
            @include('layouts.admin.sidebar')
        </div>

        <!-- Main Content -->
        <main class="flex-1 h-screen overflow-y-auto bg-slate-50 px-4 pt-4 pb-28 lg:p-8 min-w-0" style="scrollbar-width: thin; scrollbar-color: #cbd5e1 #f1f5f9;">
            <!-- Header -->
            @include('layouts.admin.header')

            <div class="mt-4 lg:mt-0">
                @yield('content')
            </div>

            @yield('head')
        </main>
    </div>
    @include('layouts.admin.bottom-nav')
    @livewireScripts
    @include('layouts.admin.toast')
    @include('layouts.admin.push')
</body>

</html>
