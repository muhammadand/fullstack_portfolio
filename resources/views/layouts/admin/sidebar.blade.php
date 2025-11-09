<aside class="w-48 bg-white h-screen p-4 shadow-sm overflow-y-auto flex flex-col" style="scrollbar-width: thin; scrollbar-color: #a78bfa #f3f4f6;">
            <style>
                aside::-webkit-scrollbar {
                    width: 6px;
                }
                aside::-webkit-scrollbar-track {
                    background: #f3f4f6;
                }
                aside::-webkit-scrollbar-thumb {
                    background: #a78bfa;
                    border-radius: 3px;
                }
                aside::-webkit-scrollbar-thumb:hover {
                    background: #8b5cf6;
                }
                main::-webkit-scrollbar {
                    width: 8px;
                }
                main::-webkit-scrollbar-track {
                    background: #f9fafb;
                }
                main::-webkit-scrollbar-thumb {
                    background: #d1d5db;
                    border-radius: 4px;
                }
                main::-webkit-scrollbar-thumb:hover {
                    background: #9ca3af;
                }
            </style>
            <!-- Logo -->
            <div class="flex items-center gap-3 mb-8 px-2">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl flex items-center justify-center">
                    <span class="text-white text-lg font-bold">F</span>
                </div>
                <span class="text-lg font-bold">FinSet</span>
            </div>

            <!-- Back Arrow -->
            <button class="w-8 h-8 mb-4 ml-2 flex items-center justify-center text-gray-600 transition-all duration-300 hover:bg-purple-50 rounded-lg hover:text-purple-600">
                <i class="fas fa-chevron-left"></i>
            </button>

            <!-- Navigation -->
            <nav class="space-y-1">
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-105">
                    <i class="fas fa-th-large text-sm"></i>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 rounded-xl transition-all duration-300 hover:bg-purple-50 hover:text-purple-600 hover:translate-x-1">
                    <i class="far fa-credit-card text-sm"></i>
                    <span class="text-sm font-medium">Transactions</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 rounded-xl transition-all duration-300 hover:bg-purple-50 hover:text-purple-600 hover:translate-x-1">
                    <i class="fas fa-wallet text-sm"></i>
                    <span class="text-sm font-medium">Wallet</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 rounded-xl transition-all duration-300 hover:bg-purple-50 hover:text-purple-600 hover:translate-x-1">
                    <i class="far fa-dot-circle text-sm"></i>
                    <span class="text-sm font-medium">Goals</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 rounded-xl transition-all duration-300 hover:bg-purple-50 hover:text-purple-600 hover:translate-x-1">
                    <i class="far fa-circle text-sm"></i>
                    <span class="text-sm font-medium">Budget</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 rounded-xl transition-all duration-300 hover:bg-purple-50 hover:text-purple-600 hover:translate-x-1">
                    <i class="fas fa-chart-bar text-sm"></i>
                    <span class="text-sm font-medium">Analytics</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 rounded-xl transition-all duration-300 hover:bg-purple-50 hover:text-purple-600 hover:translate-x-1">
                    <i class="fas fa-cog text-sm"></i>
                    <span class="text-sm font-medium">Settings</span>
                </a>
            </nav>

            <!-- Bottom Menu -->
            <div class="mt-auto pt-8 space-y-1">
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 rounded-xl transition-all duration-300 hover:bg-purple-50 hover:text-purple-600 hover:translate-x-1">
                    <i class="far fa-question-circle text-sm"></i>
                    <span class="text-sm font-medium">Help</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 rounded-xl transition-all duration-300 hover:bg-red-50 hover:text-red-600 hover:translate-x-1">
                    <i class="fas fa-sign-out-alt text-sm"></i>
                    <span class="text-sm font-medium">Log out</span>
                </a>
            </div>

            <!-- Theme Toggle -->
            <div class="mt-4 flex gap-2 px-2 pb-2">
                <button class="w-10 h-10 bg-purple-600 text-white rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg">
                    <i class="fas fa-sun text-sm"></i>
                </button>
                <button class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:bg-gray-200">
                    <i class="fas fa-moon text-sm"></i>
                </button>
            </div>
        </aside>