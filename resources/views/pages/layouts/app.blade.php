<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BarDigi - Solusi Website</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            scroll-behavior: smooth;
        }

        .gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
        }

        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .badge-tech {
            display: inline-block;
            padding: 6px 14px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border: 1px solid rgba(102, 126, 234, 0.3);
            border-radius: 20px;
            font-size: 13px;
            color: #667eea;
            font-weight: 600;
            margin: 4px;
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }
    </style>
</head>

<body class="bg-white text-gray-900">
    <!-- Navigation -->

    @include('pages.layouts.navbar')
    @yield('content') 
    @if (Route::currentRouteName() === 'landing')
        @include('pages.component.service')
        @include('pages.component.about')
        @include('pages.component.portfolio')
        @include('pages.component.testimoni')
        @include('pages.component.blogs')
        @include('pages.component.social_media')
        @include('pages.component.contact')
        @include('pages.component.cta')
    @endif
    @include('pages.layouts.footer')
</body>

</html>
