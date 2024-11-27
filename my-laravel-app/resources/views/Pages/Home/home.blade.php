@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <h1 class="text-4xl font-bold text-center mb-8">Welcome to Management System</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <a href="{{ route('workers.index') }}" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
            <h2 class="text-2xl font-semibold mb-4">Workers Management</h2>
            <p class="text-gray-600">Total Workers: {{ $workerCount }}</p>
        </a>
        
        <a href="{{ route('birds.index') }}" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
            <h2 class="text-2xl font-semibold mb-4">Birds Management</h2>
            <p class="text-gray-600">Total Birds: {{ $birdCount }}</p>
        </a>
    </div>
</div>
@endsection
