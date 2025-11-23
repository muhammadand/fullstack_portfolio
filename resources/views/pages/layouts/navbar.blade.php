<nav class="fixed w-full top-0 z-50 glass-effect border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="text-2xl font-bold gradient-text">Muhammad Andi</div>
        <div class="hidden md:flex space-x-8">
            <a href="{{ route('landing') }}" class="nav-link text-gray-700 font-medium">Home</a>
            <a href="{{route('about')}}" class="nav-link text-gray-700 font-medium">About</a>
            <a href="{{route('service')}}" class="nav-link text-gray-700 font-medium">Services</a>
            <a href="{{route('landing.portfolio')}}" class="nav-link text-gray-700 font-medium">Portfolio</a>
            <a href="{{ route('landing.blogs') }}" class="nav-link text-gray-700 font-medium">Blog</a>
            <a href="{{route('contact')}}" class="nav-link text-gray-700 font-medium">Contact</a>
        </div>
        <button onclick="window.open('https://wa.me/6285221694067?text=Hello%2C%20I%20would%20like%20to%20consult', '_blank')"
            class="gradient-primary text-white px-6 py-2 rounded-lg font-medium hover:shadow-lg transition">
            Consult
        </button>
    </div>
</nav>
