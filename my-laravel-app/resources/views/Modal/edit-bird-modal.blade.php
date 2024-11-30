<div id="editBirdModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 hidden flex justify-center items-center">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-semibold mb-4">Edit Bird</h3>
        <form id="editBirdForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="editBreed" class="block text-sm font-medium text-gray-700 mb-2">Breed</label>
                <input type="text" name="breed" id="editBreed" required 
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="editOwner" class="block text-sm font-medium text-gray-700 mb-2">Owner</label>
                <input type="text" name="owner" id="editOwner" required 
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="editHandler" class="block text-sm font-medium text-gray-700 mb-2">Handler</label>
                <select name="handler" id="editHandler" required 
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select a handler</option>
                    @foreach($workers as $worker)
                        <option value="{{ $worker->getName() }}">{{ $worker->getName() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="editImage" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                <input type="file" name="image" id="editImage" accept="image/*">
                <img id="editImagePreview" src="" alt="Preview" class="mt-2 hidden max-w-full h-32 object-contain">
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" id="cancelEditBird"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Cancel
                </button>
                <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Update Bird
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Keep your existing styles */
</style>
