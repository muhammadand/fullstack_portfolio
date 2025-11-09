@extends('layouts.admin.app')

@section('content')

<!-- Month Selector & Actions -->
            <div class="flex items-center justify-between mb-6">
                <button class="px-4 py-2 bg-white border border-gray-200 rounded-xl font-medium text-sm transition-all duration-300 hover:bg-gray-50 hover:shadow-md hover:border-purple-300">
                    <i class="far fa-calendar mr-2"></i>This month
                </button>
                <div class="flex gap-3">
                    <button class="px-5 py-2 bg-white border border-gray-200 rounded-xl font-medium text-sm transition-all duration-300 hover:bg-gray-50 hover:shadow-md hover:border-purple-300">
                        <i class="fas fa-th mr-2"></i>Manage widgets
                    </button>
                    <button class="px-5 py-2 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-xl font-medium text-sm transition-all duration-300 hover:shadow-lg hover:scale-105">
                        <i class="fas fa-plus mr-2"></i>Add new widget
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-4 gap-5 mb-6">
                <!-- Total Balance -->
                <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 cursor-pointer">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-gray-600 font-medium text-sm">Total balance</span>
                        <button class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center transition-all duration-300 hover:bg-purple-50 hover:rotate-45">
                            <i class="fas fa-arrow-up text-gray-600 text-xs"></i>
                        </button>
                    </div>
                    <div class="mb-2">
                        <span class="text-3xl font-bold text-gray-900">$15,700</span>
                        <span class="text-2xl text-gray-300">.00</span>
                    </div>
                    <div class="flex items-center gap-1 text-xs">
                        <span class="text-green-500 font-medium">↑ 12.1%</span>
                        <span class="text-gray-400">vs last month</span>
                    </div>
                </div>

                <!-- Income -->
                <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 cursor-pointer">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-gray-600 font-medium text-sm">Income</span>
                        <button class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center transition-all duration-300 hover:bg-purple-50 hover:rotate-45">
                            <i class="fas fa-arrow-up text-gray-600 text-xs"></i>
                        </button>
                    </div>
                    <div class="mb-2">
                        <span class="text-3xl font-bold text-gray-900">$8,500</span>
                        <span class="text-2xl text-gray-300">.00</span>
                    </div>
                    <div class="flex items-center gap-1 text-xs">
                        <span class="text-green-500 font-medium">↑ 6.3%</span>
                        <span class="text-gray-400">vs last month</span>
                    </div>
                </div>

                <!-- Expense -->
                <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 cursor-pointer">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-gray-600 font-medium text-sm">Expense</span>
                        <button class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center transition-all duration-300 hover:bg-purple-50 hover:rotate-45">
                            <i class="fas fa-arrow-up text-gray-600 text-xs"></i>
                        </button>
                    </div>
                    <div class="mb-2">
                        <span class="text-3xl font-bold text-gray-900">$6,222</span>
                        <span class="text-2xl text-gray-300">.00</span>
                    </div>
                    <div class="flex items-center gap-1 text-xs">
                        <span class="text-red-500 font-medium">↑ 2.4%</span>
                        <span class="text-gray-400">vs last month</span>
                    </div>
                </div>

                <!-- Total Savings -->
                <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 cursor-pointer">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-gray-600 font-medium text-sm">Total savings</span>
                        <button class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center transition-all duration-300 hover:bg-purple-50 hover:rotate-45">
                            <i class="fas fa-arrow-up text-gray-600 text-xs"></i>
                        </button>
                    </div>
                    <div class="mb-2">
                        <span class="text-3xl font-bold text-gray-900">$32,913</span>
                        <span class="text-2xl text-gray-300">.00</span>
                    </div>
                    <div class="flex items-center gap-1 text-xs">
                        <span class="text-green-500 font-medium">↑ 12.1%</span>
                        <span class="text-gray-400">vs last month</span>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-3 gap-5 mb-6">
                <!-- Money Flow Chart -->
                <div class="col-span-2 bg-white border border-gray-100 p-6 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-gray-900">Money flow</h2>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 bg-purple-500 rounded-full"></div>
                                <span class="text-xs text-gray-600">Income</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 bg-purple-300 rounded-full"></div>
                                <span class="text-xs text-gray-600">Expense</span>
                            </div>
                            <select class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs transition-all duration-300 hover:border-purple-300 cursor-pointer">
                                <option>All accounts</option>
                            </select>
                            <select class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs transition-all duration-300 hover:border-purple-300 cursor-pointer">
                                <option>This year</option>
                            </select>
                        </div>
                    </div>
                    <div class="h-56 flex items-end justify-between gap-3 px-2">
                        <div class="flex-1 flex flex-col items-center gap-2 group">
                            <div class="w-full flex gap-1 items-end h-44">
                                <div class="flex-1 bg-gradient-to-t from-purple-200 to-purple-100 rounded-t-lg transition-all duration-300 group-hover:from-purple-300 group-hover:to-purple-200" style="height: 55%"></div>
                                <div class="flex-1 bg-gradient-to-t from-purple-600 to-purple-400 rounded-t-lg transition-all duration-300 group-hover:from-purple-700 group-hover:to-purple-500" style="height: 70%"></div>
                            </div>
                            <span class="text-xs text-gray-500">Jan</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 group">
                            <div class="w-full flex gap-1 items-end h-44">
                                <div class="flex-1 bg-gradient-to-t from-purple-200 to-purple-100 rounded-t-lg transition-all duration-300 group-hover:from-purple-300 group-hover:to-purple-200" style="height: 75%"></div>
                                <div class="flex-1 bg-gradient-to-t from-purple-600 to-purple-400 rounded-t-lg transition-all duration-300 group-hover:from-purple-700 group-hover:to-purple-500" style="height: 85%"></div>
                            </div>
                            <span class="text-xs text-gray-500">Feb</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 group">
                            <div class="w-full flex gap-1 items-end h-44 relative">
                                <div class="absolute -top-7 left-1/2 transform -translate-x-1/2 bg-purple-600 text-white px-2 py-1 rounded text-xs whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">$10,000</div>
                                <div class="flex-1 bg-gradient-to-t from-purple-200 to-purple-100 rounded-t-lg transition-all duration-300 group-hover:from-purple-300 group-hover:to-purple-200" style="height: 50%"></div>
                                <div class="flex-1 bg-gradient-to-t from-purple-600 to-purple-400 rounded-t-lg transition-all duration-300 group-hover:from-purple-700 group-hover:to-purple-500" style="height: 68%"></div>
                            </div>
                            <span class="text-xs text-gray-500">Mar</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 group">
                            <div class="w-full flex gap-1 items-end h-44">
                                <div class="flex-1 bg-gradient-to-t from-purple-200 to-purple-100 rounded-t-lg transition-all duration-300 group-hover:from-purple-300 group-hover:to-purple-200" style="height: 80%"></div>
                                <div class="flex-1 bg-gradient-to-t from-purple-600 to-purple-400 rounded-t-lg transition-all duration-300 group-hover:from-purple-700 group-hover:to-purple-500" style="height: 95%"></div>
                            </div>
                            <span class="text-xs text-gray-500">Apr</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 group">
                            <div class="w-full flex gap-1 items-end h-44">
                                <div class="flex-1 bg-gradient-to-t from-purple-200 to-purple-100 rounded-t-lg transition-all duration-300 group-hover:from-purple-300 group-hover:to-purple-200" style="height: 85%"></div>
                                <div class="flex-1 bg-gradient-to-t from-purple-600 to-purple-400 rounded-t-lg transition-all duration-300 group-hover:from-purple-700 group-hover:to-purple-500" style="height: 88%"></div>
                            </div>
                            <span class="text-xs text-gray-500">May</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 group">
                            <div class="w-full flex gap-1 items-end h-44">
                                <div class="flex-1 bg-gradient-to-t from-purple-200 to-purple-100 rounded-t-lg transition-all duration-300 group-hover:from-purple-300 group-hover:to-purple-200" style="height: 60%"></div>
                                <div class="flex-1 bg-gradient-to-t from-purple-600 to-purple-400 rounded-t-lg transition-all duration-300 group-hover:from-purple-700 group-hover:to-purple-500" style="height: 65%"></div>
                            </div>
                            <span class="text-xs text-gray-500">Jun</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 group">
                            <div class="w-full flex gap-1 items-end h-44">
                                <div class="flex-1 bg-gradient-to-t from-purple-200 to-purple-100 rounded-t-lg transition-all duration-300 group-hover:from-purple-300 group-hover:to-purple-200" style="height: 70%"></div>
                                <div class="flex-1 bg-gradient-to-t from-purple-600 to-purple-400 rounded-t-lg transition-all duration-300 group-hover:from-purple-700 group-hover:to-purple-500" style="height: 72%"></div>
                            </div>
                            <span class="text-xs text-gray-500">Jul</span>
                        </div>
                    </div>
                </div>

                <!-- Budget Chart -->
                <div class="bg-white border border-gray-100 p-6 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-gray-900">Budget</h2>
                        <button class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center transition-all duration-300 hover:bg-purple-50 hover:rotate-45">
                            <i class="fas fa-arrow-up text-gray-600 text-xs"></i>
                        </button>
                    </div>
                    <div class="flex justify-center mb-6">
                        <div class="relative w-44 h-44">
                            <svg class="w-full h-full transform -rotate-90">
                                <circle cx="88" cy="88" r="70" fill="none" stroke="#f3f4f6" stroke-width="16"></circle>
                                <circle cx="88" cy="88" r="70" fill="none" stroke="#7c3aed" stroke-width="16" stroke-dasharray="440" stroke-dashoffset="110" stroke-linecap="round" class="transition-all duration-500"></circle>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-xs text-gray-400">7%</span>
                                <span class="text-xs text-gray-500">$400</span>
                                <span class="text-xs text-gray-500 mt-1">Total for month</span>
                                <span class="text-xl font-bold text-gray-900">$5,950</span>
                                <span class="text-lg text-gray-300">.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2.5">
                        <div class="flex items-center justify-between text-xs transition-all duration-300 hover:translate-x-1 cursor-pointer">
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 bg-purple-500 rounded-full"></div>
                                <span class="text-gray-700">Cafe & Restaurants</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-xs transition-all duration-300 hover:translate-x-1 cursor-pointer">
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 bg-purple-300 rounded-full"></div>
                                <span class="text-gray-700">Entertainment</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-xs transition-all duration-300 hover:translate-x-1 cursor-pointer">
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 bg-gray-300 rounded-full"></div>
                                <span class="text-gray-700">Investments</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-xs transition-all duration-300 hover:translate-x-1 cursor-pointer">
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 bg-gray-800 rounded-full"></div>
                                <span class="text-gray-700">Food & Groceries</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-xs transition-all duration-300 hover:translate-x-1 cursor-pointer">
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 bg-purple-200 rounded-full"></div>
                                <span class="text-gray-700">Health & Beauty</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-xs transition-all duration-300 hover:translate-x-1 cursor-pointer">
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 bg-gray-400 rounded-full"></div>
                                <span class="text-gray-700">Traveling</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Row -->
            <div class="grid grid-cols-3 gap-5">
                <!-- Recent Transactions -->
                <div class="col-span-2 bg-white border border-gray-100 p-6 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-gray-900">Recent transactions</h2>
                        <div class="flex gap-2">
                            <select class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs transition-all duration-300 hover:border-purple-300 cursor-pointer">
                                <option>All accounts</option>
                            </select>
                            <button class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs transition-all duration-300 hover:bg-purple-50 hover:text-purple-600 hover:border-purple-300">
                                See all <i class="fas fa-chevron-right ml-1"></i>
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="text-left py-3 text-xs font-semibold text-purple-600 uppercase">Date</th>
                                    <th class="text-left py-3 text-xs font-semibold text-purple-600 uppercase">Amount</th>
                                    <th class="text-left py-3 text-xs font-semibold text-purple-600 uppercase">Payment Name</th>
                                    <th class="text-left py-3 text-xs font-semibold text-purple-600 uppercase">Method</th>
                                    <th class="text-left py-3 text-xs font-semibold text-purple-600 uppercase">Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-50 transition-all duration-300 hover:bg-purple-50 cursor-pointer">
                                    <td class="py-3 text-sm text-gray-700">25 Jul 12:30</td>
                                    <td class="py-3 text-sm font-semibold text-gray-900">- $10</td>
                                    <td class="py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 bg-red-500 rounded-lg flex items-center justify-center">
                                                <i class="fab fa-youtube text-white text-xs"></i>
                                            </div>
                                            <span class="text-sm text-gray-900">YouTube</span>
                                        </div>
                                    </td>
                                    <td class="py-3 text-sm text-gray-600">VISA **3254</td>
                                    <td class="py-3 text-sm text-gray-600">Subscription</td>
                                </tr>
                                <tr class="border-b border-gray-50 transition-all duration-300 hover:bg-purple-50 cursor-pointer">
                                    <td class="py-3 text-sm text-gray-700">26 Jul 15:00</td>
                                    <td class="py-3 text-sm font-semibold text-gray-900">- $150</td>
                                    <td class="py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <span class="text-xs text-gray-600">••••</span>
                                            </div>
                                            <span class="text-sm text-gray-900">Reserved</span>
                                        </div>
                                    </td>
                                    <td class="py-3 text-sm text-gray-600">Mastercard **2154</td>
                                    <td class="py-3 text-sm text-gray-600">Shopping</td>
                                </tr>
                                <tr class="border-b border-gray-50 transition-all duration-300 hover:bg-purple-50 cursor-pointer">
                                    <td class="py-3 text-sm text-gray-700">27 Jul 9:00</td>
                                    <td class="py-3 text-sm font-semibold text-gray-900">- $80</td>
                                    <td class="py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 bg-pink-500 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-utensils text-white text-xs"></i>
                                            </div>
                                            <span class="text-sm text-gray-900">Yaposhka</span>
                                        </div>
                                    </td>
                                    <td class="py-3 text-sm text-gray-600">Mastercard **2154</td>
                                    <td class="py-3 text-sm text-gray-600">Cafe & Restaurants</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Saving Goals -->
                <div class="bg-white border border-gray-100 p-6 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-gray-900">Saving goals</h2>
                        <button class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center transition-all duration-300 hover:bg-purple-50 hover:rotate-45">
                            <i class="fas fa-arrow-up text-gray-600 text-xs"></i>
                        </button>
                    </div>
                    <div class="space-y-5">
                        <!-- Goal 1: MacBook Pro -->
                        <div class="transition-all duration-300 hover:translate-x-2 cursor-pointer">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-900">MacBook Pro</span>
                                <span class="text-sm font-semibold text-purple-600">$1,650</span>
                            </div>
                            <div class="w-full bg-purple-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-full rounded-full transition-all duration-500 hover:from-purple-600 hover:to-purple-700" style="width: 25%"></div>
                            </div>
                            <span class="text-xs text-purple-600 mt-1 block font-medium">25%</span>
                        </div>

                        <!-- Goal 2: New car -->
                        <div class="transition-all duration-300 hover:translate-x-2 cursor-pointer">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-900">New car</span>
                                <span class="text-sm font-semibold text-purple-600">$60,000</span>
                            </div>
                            <div class="w-full bg-purple-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-full rounded-full transition-all duration-500 hover:from-purple-600 hover:to-purple-700" style="width: 42%"></div>
                            </div>
                            <span class="text-xs text-purple-600 mt-1 block font-medium">42%</span>
                        </div>

                        <!-- Goal 3: New house -->
                        <div class="transition-all duration-300 hover:translate-x-2 cursor-pointer">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-900">New house</span>
                                <span class="text-sm font-semibold text-purple-600">$150,000</span>
                            </div>
                            <div class="w-full bg-purple-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-full rounded-full transition-all duration-500 hover:from-purple-600 hover:to-purple-700" style="width: 3%"></div>
                            </div>
                            <span class="text-xs text-purple-600 mt-1 block font-medium">3%</span>
                        </div>
                    </div>
                </div>
            </div>
@endsection