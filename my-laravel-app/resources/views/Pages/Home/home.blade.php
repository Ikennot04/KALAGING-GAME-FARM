@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-4xl font-bold text-center text-gray-900 mb-8">Welcome to Management System</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <a href="{{ route('workers.index') }}" 
           class="transform hover:scale-105 transition-transform duration-200">
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Workers Management</h2>
                <div class="flex justify-between items-center">
                    <p class="text-gray-600">Total Workers: {{ $workerCount }}</p>
                    <span class="text-blue-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </span>
                </div>
            </div>
        </a>
        
        <a href="{{ route('birds.index') }}" 
           class="transform hover:scale-105 transition-transform duration-200">
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Birds Management</h2>
                <div class="flex justify-between items-center">
                    <p class="text-gray-600">Total Birds: {{ $birdCount }}</p>
                    <span class="text-blue-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </span>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection
