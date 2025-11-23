<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BarDigi - Solusi Website</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

</head>
<body class="bg-gradient-to-br from-purple-100 via-purple-50 to-white h-screen overflow-hidden">
    <div class="flex h-screen">
      
     
  <!-- Sidebar -->
        @include('layouts.admin.sidebar')

        <!-- Main Content -->
        <main class="flex-1 h-screen overflow-y-auto p-8" style="scrollbar-width: thin; scrollbar-color: #d1d5db #f9fafb;">
            <!-- Header -->
            @include('layouts.admin.header')
            @yield('content')
              @yield('head')
        </main>
    </div>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</body>
</html>