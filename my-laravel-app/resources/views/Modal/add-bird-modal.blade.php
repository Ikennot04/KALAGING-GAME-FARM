<!-- Add Modal -->
<div id="addBirdModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 hidden flex justify-center items-center">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-semibold mb-4">Add New Bird</h3>
        <form id="addBirdForm" action="{{ route('birds.add') }}" method="POST" enctype="multipart/form-data">
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
                <select name="handler" id="handler" required 
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select a handler</option>
                    @foreach($workers as $worker)
                        <option value="{{ $worker->getName() }}">{{ $worker->getName() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                <input type="file" name="image" id="image" accept="image/*" required 
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <img id="imagePreview" alt="Bird Preview" class="mt-2 max-w-[200px] h-auto hidden">
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" id="cancelAddBird"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Cancel
                </button>
                <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Add Bird
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        const modal = document.getElementById('addBirdModal');
        modal.classList.remove('hidden');
    }

    function closeAddModal() {
        const modal = document.getElementById('addBirdModal');
        modal.classList.add('hidden');
    }
</script>