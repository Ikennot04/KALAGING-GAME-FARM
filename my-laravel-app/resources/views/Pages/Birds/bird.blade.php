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
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button 
                            class="text-red-600 hover:text-red-900 delete-bird-btn mr-2"
                            data-bird-id="{{ $bird->getId() }}"
                        >
                            Delete
                        </button>
                        <button 
                            class="text-blue-600 hover:text-blue-900 edit-bird-btn"
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

    <!-- Archive Confirmation Modal -->
    <div id="archive-modal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm w-full">
            <h3 class="text-xl font-semibold text-gray-800">Confirm Archive</h3>
            <p class="mt-2 text-sm text-gray-600">Are you sure you want to archive this bird?</p>
            <div class="mt-4 flex justify-end">
                <button id="cancel-archive" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                    Cancel
                </button>
                <button id="confirm-archive" class="ml-2 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Archive
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

@section('scripts')
    <script src="{{ asset('js/search-birds.js') }}"></script>
@endsection