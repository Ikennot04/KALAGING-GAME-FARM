<!-- Add Modal -->
<div id="addWorkerModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex justify-center items-center z-50" style="display: none;">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-semibold mb-4">Add New Worker</h3>
        
       

        <form id="addWorkerForm" action="{{ route('workers.add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <input type="text" 
                       id="name" 
                       name="name"
                       required 
                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="mb-4">
                <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Position</label>
                <select id="position" 
                        name="position" 
                        required 
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Position</option>
                    <option value="Senior Handler">Senior Handler</option>
                    <option value="Junior Handler">Junior Handler</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                <input type="file" 
                       id="image" 
                       name="image"
                       accept="image/*" 
                       required 
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <img id="imagePreview" class="mt-2 max-w-[200px] h-auto" style="display: none;">
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" 
                        id="cancelAddWorker"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Cancel
                </button>
                <button type="submit" 
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                    Add Worker
                </button>
            </div>
        </form>
    </div>
</div>
