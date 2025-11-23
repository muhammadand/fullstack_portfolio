<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BarDigi - Solusi Website</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'purple-gradient-start': '#667eea',
                        'purple-gradient-end': '#764ba2',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow: hidden;
        }
        .card-3d {
            background: linear-gradient(135deg, #667eea 0%, #5a67d8 100%);
            width: 280px;
            height: 180px;
            transform: perspective(800px) rotateY(-20deg) rotateX(5deg);
            box-shadow: 0 30px 80px rgba(0,0,0,0.3);
        }
        .lock-3d {
            background: linear-gradient(135deg, #4fd1c5 0%, #38b2ac 100%);
            box-shadow: 0 15px 40px rgba(79, 209, 197, 0.5);
        }
        .floating-shape {
            background: rgba(255, 255, 255, 0.15);
            animation: float 4s ease-in-out infinite;
        }
        .floating-shape:nth-child(2) { animation-delay: 1s; }
        .floating-shape:nth-child(3) { animation-delay: 2s; }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-25px) rotate(5deg); }
        }
        .btn-gradient {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
        }
        .btn-gradient:hover {
            background: linear-gradient(135deg, #6d28d9 0%, #5b21b6 100%);
        }
    </style>
</head>
<body class="h-screen w-screen overflow-hidden">

    @yield('content')

    <script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
}
</script>
<!-- Tambahkan sebelum </body> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Jika ada session success
    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    @endif

    // Jika ada session error
    @if(session('error'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    @endif
});
</script>


</body>
</html>

