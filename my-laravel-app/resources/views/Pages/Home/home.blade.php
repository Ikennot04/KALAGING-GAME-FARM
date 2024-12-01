@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-4xl font-bold text-center text-gray-900 mb-8">Welcome to KGFs ADMIN </h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <a href="{{ route('workers.index') }}" 
           class="transform hover:scale-105 transition-transform duration-200">
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Handlers Management</h2>
                <div class="flex justify-between items-center">
                    <p class="text-gray-600">Total Handlers: {{ $workerCount }}</p>
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

    @if(isset($handlerStats) && count($handlerStats) > 0)
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Handler Statistics</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Handler</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Position</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Birds Handled</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($handlerStats as $stat)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img src="{{ asset('storage/images/' . $stat['image']) }}" 
                                     alt="{{ $stat['name'] }}" 
                                     class="h-10 w-10 rounded-full object-cover">
                                <span class="ml-4 text-sm font-medium text-gray-900">{{ $stat['name'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $stat['position'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-sm rounded-full {{ $stat['bird_count'] > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ $stat['bird_count'] }} birds
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection