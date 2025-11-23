@extends('auth.app')
@section('content')
<div class="h-screen flex items-center justify-center p-8">
    <div class="w-full max-w-7xl h-full max-h-[900px] bg-white rounded-3xl shadow-2xl flex overflow-hidden">

        <!-- Left Side - Illustration -->
        <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-16 relative bg-gradient-to-br from-purple-50 to-blue-50">

            <!-- Floating Shapes -->
            <div class="floating-shape absolute top-20 left-16 w-20 h-20 rounded-xl"></div>
            <div class="floating-shape absolute top-40 right-24 w-16 h-16 rounded-lg"></div>
            <div class="floating-shape absolute bottom-32 left-32 w-24 h-24 rounded-2xl"></div>
            <div class="floating-shape absolute bottom-20 right-16 w-14 h-14 rounded-lg"></div>

            <!-- Main Illustration -->
            <div class="relative z-10">
                <!-- 3D Card -->
                <div class="card-3d rounded-2xl relative">
                    <div class="absolute top-6 left-6 w-20 h-1 bg-white/40 rounded-full"></div>
                    <div class="absolute top-10 left-6 w-32 h-1 bg-white/30 rounded-full"></div>
                    <div class="absolute top-16 left-6 w-12 h-12 bg-white/20 rounded-full"></div>
                </div>

                <!-- Lock Icon -->
                <div class="lock-3d absolute -bottom-4 -right-12 w-24 h-24 rounded-2xl flex items-center justify-center z-20">
                    <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-10">
            <div class="w-full max-w-md">

                <!-- Header -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-indigo-600 rounded-lg flex items-center justify-center relative overflow-hidden">
                                <div class="absolute inset-0 bg-white opacity-20 transform rotate-45 translate-x-1 translate-y-1"></div>
                                <div class="absolute inset-0 bg-white opacity-10 transform rotate-45 translate-x-2 translate-y-2"></div>
                            </div>
                            <span class="text-xl font-bold text-indigo-600">MUHAMMAD ANDI</span>
                        </div>

                        <!-- Register Button -->
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500 hidden sm:inline">Don't have an account?</span>
                            <a href="{{ route('register') }}" class="text-xs font-medium text-gray-700 border border-gray-300 px-3 py-1.5 rounded-lg hover:bg-gray-50 transition">
                                REGISTER
                            </a>
                        </div>
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 mb-1">Welcome Back!</h1>
                    <p class="text-gray-500 text-sm">Login to your account</p>
                </div>

                {{-- Error Message --}}
                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-4 text-xs border border-red-200">
                        <ul class="list-disc ml-4 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1.5 text-sm">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full border-2 border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition text-gray-500 text-sm"
                               placeholder="focus001@gmail.com">
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1.5 text-sm">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                   class="w-full border-2 border-gray-200 rounded-xl px-4 py-2.5 pr-11 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition text-gray-500 text-sm"
                                   placeholder="8+ characters">
                            <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full btn-gradient text-white py-3 rounded-xl font-semibold text-base shadow-lg shadow-purple-500/50 hover:shadow-xl hover:shadow-purple-600/50 transition-all duration-300 transform hover:-translate-y-0.5 mt-2">
                        Login
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection

