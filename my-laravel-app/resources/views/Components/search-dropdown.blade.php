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
                <!-- ... exact match template ... -->
            </template>

            <!-- Related Results -->
            <template x-if="searchResults.related && searchResults.related.length > 0">
                <!-- ... related results template ... -->
            </template>

            <!-- No Results Message -->
            <template x-if="!searchResults.match && (!searchResults.related || searchResults.related.length === 0) && searchTerm.length >= 2">
                <!-- ... no results template ... -->
            </template>
        </div>
    </div>
</div> 