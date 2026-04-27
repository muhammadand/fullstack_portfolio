<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Navy & Gold</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#1E2A38',
                        gold: '#C9A96E',
                        olive: '#6B705C',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-navy text-white min-h-screen">

    <nav class="fixed w-full top-0 z-50 backdrop-blur-md bg-navy/80 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-8 py-6 flex justify-between items-center">
            <div class="text-xl font-semibold tracking-[0.2em] text-gold uppercase">Heritage</div>
            <div class="hidden md:flex gap-10 text-[10px] uppercase tracking-[0.3em] text-gray-400">
                <a href="#" class="hover:text-gold transition">Portfolio</a>
                <a href="#" class="hover:text-gold transition">Process</a>
                <a href="#" class="hover:text-gold transition">Inquiry</a>
            </div>
        </div>
    </nav>

    <main>
        @include('portfolio.landingPage.hero')
    </main>

    <section class="bg-white/5 py-24">
        <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 md:grid-cols-3 gap-16">
            <div>
                <h4 class="text-gold text-xs font-bold tracking-[0.3em] uppercase mb-4">The Navy</h4>
                <p class="text-sm text-gray-400 leading-relaxed">Warna dasar yang memberikan fondasi kuat,
                    profesionalisme, dan kredibilitas tinggi pada setiap aspek digital.</p>
            </div>
            <div>
                <h4 class="text-gold text-xs font-bold tracking-[0.3em] uppercase mb-4">The Olive</h4>
                <p class="text-sm text-gray-400 leading-relaxed">Memberikan nuansa alami dan tenang, menjauhkan kesan
                    kaku dan membosankan dari desain korporat biasa.</p>
            </div>
            <div>
                <h4 class="text-gold text-xs font-bold tracking-[0.3em] uppercase mb-4">The Gold</h4>
                <p class="text-sm text-gray-400 leading-relaxed">Aksen yang mendefinisikan kualitas premium. Digunakan
                    secara halus untuk mengarahkan atensi secara elegan.</p>
            </div>
        </div>
    </section>

    <footer class="py-12 text-center">
        <div class="w-16 h-px bg-gold mx-auto mb-8 opacity-50"></div>
        <p class="text-[10px] text-olive tracking-[0.5em] uppercase">Built with Excellence &bull; 2024</p>
    </footer>

</body>

</html>
