<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workers Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8" x-data="workerManagement()">
        <!-- Page Title -->
        <h1 class="text-3xl font-semibold text-gray-800 text-center mb-4">Workers Management</h1>
        
        <!-- Search and Add Worker Section -->
        <div class="flex justify-between items-center mb-6">
            <div class="w-1/3">
                <div class="relative">
                    <input 
                        type="text" 
                        x-model="searchTerm"
                        @input.debounce.300ms="performSearch()"
                        placeholder="Search by name or position..."
                        class="w-full px-4 py-2 border rounded-lg"
                    >
                    <!-- Search Results Dropdown -->
                    <div x-show="searchResults.match || (searchResults.related && searchResults.related.length > 0)"
                         class="absolute z-50 w-full mt-1 bg-white border rounded-lg shadow-lg">
                        <!-- Exact Match -->
                        <template x-if="searchResults.match">
                            <div class="p-2 border-b">
                                <div class="font-semibold">Best Match:</div>
                                <div class="flex items-center space-x-2 py-1 hover:bg-gray-100 cursor-pointer"
                                     @click="highlightAndScrollTo(searchResults.match.id)">
                                    <img :src="getImageUrl(searchResults.match.image)" class="w-8 h-8 rounded-full object-cover">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <span x-text="searchResults.match.name"></span>
                                            <span class="text-sm text-gray-500" x-text="searchResults.match.position"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Related Results -->
                        <template x-if="searchResults.related && searchResults.related.length > 0">
                            <div class="p-2">
                                <div class="font-semibold mb-2">Related Results:</div>
                                <template x-for="worker in searchResults.related" :key="worker.id">
                                    <div @click="highlightAndScrollTo(worker.id)"
                                         class="flex items-center space-x-2 py-1 hover:bg-gray-100 cursor-pointer">
                                        <img :src="getImageUrl(worker.image)" class="w-8 h-8 rounded-full object-cover">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <span x-text="worker.name"></span>
                                                <span class="text-sm text-gray-500" x-text="worker.position"></span>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <button @click="$dispatch('open-add-modal')"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">
                Add New Worker
            </button>
        </div>

        <!-- Workers Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 border-b text-left">ID</th>
                        <th class="px-6 py-3 border-b text-left">Image</th>
                        <th class="px-6 py-3 border-b text-left">Name</th>
                        <th class="px-6 py-3 border-b text-left">Position</th>
                        <th class="px-6 py-3 border-b text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workers as $worker)
                    <tr id="worker-row-{{ $worker->getId() }}"
                        class="hover:bg-gray-50 transition-colors duration-300">
                        <td class="px-6 py-4 border-b">#{{ $worker->getId() }}</td>
                        <td class="px-6 py-4 border-b">
                            <img src="{{ Storage::url('images/' . ($worker->getImage() ?? 'default.jpg')) }}"
                                 alt="{{ $worker->getName() }}"
                                 class="w-12 h-12 rounded-full object-cover">
                        </td>
                        <td class="px-6 py-4 border-b">{{ $worker->getName() }}</td>
                        <td class="px-6 py-4 border-b">{{ $worker->getPosition() }}</td>
                        <td class="px-6 py-4 border-b text-center">
                            <button @click="$dispatch('open-edit-modal', {
                                        id: '{{ $worker->getId() }}',
                                        name: '{{ $worker->getName() }}',
                                        position: '{{ $worker->getPosition() }}',
                                        image: '{{ $worker->getImage() }}'
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
        @include('Modal.edit-worker-modal')
        @include('Modal.add-worker-modal')
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('workerManagement', () => ({
                searchTerm: '',
                searchResults: {
                    match: null,
                    related: []
                },

                async performSearch() {
                    if (!this.searchTerm) {
                        this.searchResults = { match: null, related: [] };
                        return;
                    }

                    try {
                        const response = await fetch(`/api/workers/search?search=${this.searchTerm}`);
                        const data = await response.json();
                        this.searchResults = data;
                    } catch (error) {
                        console.error('Search failed:', error);
                    }
                },

                getImageUrl(image) {
                    return image ? `/storage/images/${image}` : '/storage/images/default.jpg';
                },

                highlightAndScrollTo(workerId) {
                    const row = document.getElementById(`worker-row-${workerId}`);
                    if (!row) return;

                    // Remove any existing highlights
                    document.querySelectorAll('tr.bg-yellow-100').forEach(el => {
                        el.classList.remove('bg-yellow-100');
                    });

                    // Add highlight to the target row
                    row.classList.add('bg-yellow-100');
                    row.scrollIntoView({ behavior: 'smooth', block: 'center' });

                    // Remove highlight after 2 seconds
                    setTimeout(() => {
                        row.classList.remove('bg-yellow-100');
                    }, 2000);

                    // Clear search results
                    this.searchResults = { match: null, related: [] };
                    this.searchTerm = '';
                }
            }));
        });
    </script>
</body>
</html>
