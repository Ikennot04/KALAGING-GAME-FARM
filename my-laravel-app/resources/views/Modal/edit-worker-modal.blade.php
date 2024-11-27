<div id="editWorkerModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50" style="display: none;">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-bold mb-4">Edit Worker</h2>
        
        <form id="editWorkerForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-4">
                <label for="editName" class="block mb-1">Name:</label>
                <input type="text" 
                    id="editName" 
                    name="name" 
                    class="w-full border rounded px-2 py-1"
                    required>
            </div>

            <div class="form-group mb-4">
                <label for="editPosition" class="block mb-1">Position:</label>
                <input type="text" 
                    id="editPosition" 
                    name="position" 
                    class="w-full border rounded px-2 py-1"
                    required>
            </div>

            <div class="form-group mb-4">
                <label for="editImage" class="block mb-1">Image:</label>
                <input type="file" 
                    id="editImage" 
                    name="image" 
                    class="w-full">
                <img id="editImagePreview" 
                    alt="Worker Image" 
                    class="mt-2 max-w-[200px] h-auto">
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" 
                    id="cancelEditWorker"
                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
