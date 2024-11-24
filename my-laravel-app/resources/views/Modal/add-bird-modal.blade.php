<!-- Add Modal -->
<div id="addModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 hidden flex justify-center items-center">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-semibold mb-4">Add New Bird</h3>
        <form action="{{ route('birds.add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="breed" class="block text-sm font-medium text-gray-700 mb-2">Breed</label>
                <input type="text" name="breed" id="breed" required 
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="owner" class="block text-sm font-medium text-gray-700 mb-2">Owner</label>
                <input type="text" name="owner" id="owner" required 
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="handler" class="block text-sm font-medium text-gray-700 mb-2">Handler</label>
                <input type="text" name="handler" id="handler" required 
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                <input type="file" name="image" id="image" accept="image/*" required 
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeAddModal()" 
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Cancel
                </button>
                <button type="submit" 
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                    Add Bird
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        const modal = document.getElementById('addModal');
        modal.classList.remove('hidden');
    }

    function closeAddModal() {
        const modal = document.getElementById('addModal');
        modal.classList.add('hidden');
    }
</script>