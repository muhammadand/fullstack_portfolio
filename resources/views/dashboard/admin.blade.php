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
         @include('dashboard.card')
         @include('dashboard.chart')
         @include('dashboard.popular')

     
@endsection