@extends('layouts.app')

@section('title', 'Birds Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold text-gray-800 text-center mb-4">Birds Management</h1>
    
    <div class="flex justify-between items-center mb-6">
        <div class="w-1/3">
            <div class="relative">
                <input 
                    type="text" 
                    id="searchInput"
                    placeholder="Search by ID, name or position..."
                    class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <div 
                    id="searchResults"
                    class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg border border-gray-200"
                    style="display: none;"
                ></div>
            </div>
        </div>

        <button 
            id="addBirdBtn"
            class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-md flex items-center"
        >
            <span class="mr-2">+</span> Add Bird
        </button>
    </div>

    <!-- Workers Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Breed</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Handler</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($birds as $bird)
                <tr id="bird-row-{{ $bird->getId() }}" class="transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $bird->getId() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="{{ asset('storage/images/' . $bird->getImage()) }}" 
                             alt="{{ $bird->getOwner() }}" 
                             class="h-10 w-10 rounded-full object-cover">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $bird->getBreed() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $bird->getOwner() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $bird->getHandler() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button 
                            class="edit-bird-btn text-indigo-600 hover:text-indigo-900"
                            data-bird-id="{{ $bird->getId() }}"
                            data-breed="{{ $bird->getBreed() }}"
                            data-owner="{{ $bird->getOwner() }}"
                            data-handler="{{ $bird->getHandler() }}"
                            data-image="{{ $bird->getImage() }}"
                        >
                            Edit
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modals -->
    @include('Modal.add-bird-modal')
    @include('Modal.edit-bird-modal')
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/search-birds.js') }}"></script>
@endsection
