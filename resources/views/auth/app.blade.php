<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scalify Intelligence - Authentication</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('scalify.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'midnight-start': '#0B1120'
                        , 'midnight-end': '#1E3A8A',
                        /* True dark blue */
                    }
                }
            }
        }

    </script>
    <style>
        body {
            /* True Midnight Blue gradient with a noticeable blue tint */
            background: linear-gradient(135deg, #0B1120 0%, #172554 100%);
            overflow: hidden;
            color: white;
        }

        /* Glassmorphism utility classes */
        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }

        .glass-input:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(96, 165, 250, 0.5);
            /* Blue-400 */
            outline: none;
            box-shadow: 0 0 15px rgba(96, 165, 250, 0.2);
        }

        /* Illustrations */
        .card-3d {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.02) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 280px;
            height: 180px;
            transform: perspective(800px) rotateY(-20deg) rotateX(5deg);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
        }

        .lock-3d {
            background: linear-gradient(135deg, #3B82F6 0%, #1E40AF 100%);
            /* Bright blue accent */
            box-shadow: 0 15px 40px rgba(59, 130, 246, 0.4);
        }

        .floating-shape {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
            animation: float 5s ease-in-out infinite;
        }

        .floating-shape:nth-child(2) {
            animation-delay: 1.5s;
        }

        .floating-shape:nth-child(3) {
            animation-delay: 3s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-25px) rotate(5deg);
            }
        }

        /* Custom Scrollbar for dropdowns */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

    </style>
</head>
<body class="h-screen w-screen overflow-hidden text-slate-100">

    <!-- Decorative background glow -->
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-blue-600/20 blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-indigo-600/20 blur-[120px] pointer-events-none"></div>

    @yield('content')

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        }

    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
            Swal.fire({
                toast: true
                , position: 'top-end'
                , icon: 'success'
                , title: '{{ session('
                success ') }}'
                , background: '#1E293B'
                , color: '#fff'
                , showConfirmButton: false
                , timer: 3000
                , timerProgressBar: true
            , });
            @endif

            @if(session('error'))
            Swal.fire({
                toast: true
                , position: 'top-end'
                , icon: 'error'
                , title: '{{ session('
                error ') }}'
                , background: '#1E293B'
                , color: '#fff'
                , showConfirmButton: false
                , timer: 3000
                , timerProgressBar: true
            , });
            @endif
        });

    </script>
</body>
</html>
