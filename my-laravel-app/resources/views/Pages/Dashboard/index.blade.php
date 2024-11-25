<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birds List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('js/search-birds.js') }}"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8" x-data="searchBirds()">
        <!-- Page Title -->
        <h1 class="text-3xl font-semibold text-gray-800 text-center mb-4">Birds Management</h1>
        
        <!-- Search and Add Bird Section -->
        <div class="flex justify-between items-center mb-6">
            <!-- Search Input -->
            <div class="w-1/3">
                <div class="relative">
                    <input 
                        type="text" 
                        x-model="searchTerm"
                        @input.debounce.300ms="performSearch()"
                        placeholder="Search by ID, breed, owner, or handler..."
                        class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    <!-- Search Results Dropdown -->
                    <div 
                        x-show="showResults"
                        @click.away="showResults = false"
                        class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg border border-gray-200"
                    >
                        <!-- Exact Match -->
                        <template x-if="searchResults.match">
                            <div 
                                @click="highlightAndScrollTo(searchResults.match.id)"
                                class="p-2 border-b border-gray-200 bg-blue-50 hover:bg-blue-100 cursor-pointer"
                            >
                                <div class="font-semibold">Exact Match:</div>
                                <div class="flex items-center space-x-2">
                                    <img :src="getImageUrl(searchResults.match.image)" class="w-8 h-8 rounded-full object-cover">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <span x-text="searchResults.match.breed"></span>
                                            <span class="text-sm text-gray-500" x-text="'ID: ' + searchResults.match.id"></span>
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            <span x-text="searchResults.match.owner"></span>
                                            (<span x-text="searchResults.match.handler"></span>)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Related Results -->
                        <template x-if="searchResults.related && searchResults.related.length > 0">
                            <div class="p-2">
                                <div class="font-semibold mb-2">Related Results:</div>
                                <template x-for="bird in searchResults.related" :key="bird.id">
                                    <div 
                                        @click="highlightAndScrollTo(bird.id)"
                                        class="flex items-center space-x-2 py-1 hover:bg-gray-100 cursor-pointer"
                                    >
                                        <img :src="getImageUrl(bird.image)" class="w-8 h-8 rounded-full object-cover">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <span x-text="bird.breed"></span>
                                                <span class="text-sm text-gray-500" x-text="'ID: ' + bird.id"></span>
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                <span x-text="bird.owner"></span>
                                                (<span x-text="bird.handler"></span>)
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <!-- No Results Message -->
                        <template x-if="!searchResults.match && (!searchResults.related || searchResults.related.length === 0) && searchTerm.length >= 2">
                            <div class="p-2 text-gray-500 text-center">
                                No results found
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Add Bird Button -->
            <button 
                onclick="openAddModal()" 
                class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-md flex items-center">
                <span class="mr-2 text-lg font-bold">+</span> Add Bird
            </button>
        </div>
        
        <!-- Birds Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mt-6">
            <table class="min-w-full table-fixed border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="w-1/12 border border-gray-300 px-4 py-2 text-left">ID</th>
                        <th class="w-1/6 border border-gray-300 px-4 py-2 text-left">Image</th>
                        <th class="w-1/5 border border-gray-300 px-4 py-2 text-left">Breed</th>
                        <th class="w-1/5 border border-gray-300 px-4 py-2 text-left">Owner</th>
                        <th class="w-1/5 border border-gray-300 px-4 py-2 text-left">Handler</th>
                        <th class="w-1/6 border border-gray-300 px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($birds as $bird)
                    <tr 
                        id="bird-row-{{ $bird->getId() }}"
                        class="hover:bg-gray-50 transition-colors duration-300"
                    >
                        <td class="border border-gray-300 px-4 py-2 text-gray-600">
                            #{{ $bird->getId() }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $bird->getBreed() }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <img src="{{ $bird->getImage() && $bird->getImage() !== 'default.jpg' && Storage::disk('public')->exists('images/' . $bird->getImage()) 
                                ? Storage::url('images/' . $bird->getImage()) 
                                : Storage::url('images/default.jpg') }}" 
                                alt="Bird Image" 
                                class="w-20 h-20 object-cover rounded-md">
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $bird->getOwner() }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $bird->getHandler() }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <button 
                                type="button"
                                @click="$dispatch('open-edit-modal', {
                                    id: '{{ $bird->getId() }}',
                                    breed: '{{ $bird->getBreed() }}',
                                    owner: '{{ $bird->getOwner() }}',
                                    handler: '{{ $bird->getHandler() }}',
                                    image: '{{ $bird->getImage() }}'
                                })"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                                Edit
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Include Modals -->
        @include('Modal.edit-bird-modal')
        @include('Modal.add-bird-modal')
    </div>

    <style>
        /* Add this to your CSS */
        .bg-yellow-100 {
            background-color: #fef9c3;
        }

        /* Optional: Add animation for the highlight */
        .transition-colors {
            transition: background-color 0.5s ease;
        }
    </style>
</body>
</html>
