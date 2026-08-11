<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scalify Admin — Dashboard</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('scalify.png') }}">

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
</head>

<body class="bg-slate-50 font-sans h-screen overflow-hidden">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen relative w-full overflow-hidden">

        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 bg-slate-900/60 z-40 lg:hidden backdrop-blur-sm" style="display: none;"></div>

        <!-- Sidebar Container -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed lg:relative z-50 h-screen transition-transform duration-300 ease-in-out lg:translate-x-0 shadow-2xl lg:shadow-none">
            @include('layouts.admin.sidebar')
        </div>

        <!-- Main Content -->
        <main class="flex-1 h-screen overflow-y-auto bg-slate-50 p-4 lg:p-8 min-w-0" style="scrollbar-width: thin; scrollbar-color: #cbd5e1 #f1f5f9;">
            <!-- Header -->
            @include('layouts.admin.header')

            <div class="mt-4 lg:mt-0">
                @yield('content')
            </div>

            @yield('head')
        </main>
    </div>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>
