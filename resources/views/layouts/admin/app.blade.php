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
    <div class="flex h-screen">

        <!-- Sidebar -->
        @include('layouts.admin.sidebar')

        <!-- Main Content -->
        <main class="flex-1 h-screen overflow-y-auto bg-slate-50 p-8" style="scrollbar-width: thin; scrollbar-color: #cbd5e1 #f1f5f9;">
            <!-- Header -->
            @include('layouts.admin.header')
            @yield('content')
            @yield('head')
        </main>
    </div>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>
