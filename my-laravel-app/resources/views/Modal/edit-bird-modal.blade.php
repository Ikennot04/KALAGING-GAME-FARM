<div id="editModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 hidden flex justify-center items-center">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-semibold mb-4">Edit Bird</h3>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Current Image Preview -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                <img id="currentImage" src="" alt="Bird Image" class="w-32 h-32 object-cover rounded">
            </div>

            <!-- Image Upload -->
            <div class="mb-4">
                <label for="editImage" class="block text-sm font-medium text-gray-700 mb-2">Update Image</label>
                <input type="file" 
                    name="image" 
                    id="editImage" 
                    accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div class="mb-4">
                <label for="editBreed" class="block text-sm font-medium text-gray-700 mb-2">Breed</label>
                <input type="text" name="breed" id="editBreed" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="editOwner" class="block text-sm font-medium text-gray-700 mb-2">Owner</label>
                <input type="text" name="owner" id="editOwner" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="editHandler" class="block text-sm font-medium text-gray-700 mb-2">Handler</label>
                <input type="text" name="handler" id="editHandler" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Cancel</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</div>


<script>
   function openModal(id, breed, owner, handler, image) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');

    // Set form action
    form.action = `/birds/${id}`;

    // Set input values
    document.getElementById('editBreed').value = breed;
    document.getElementById('editOwner').value = owner;
    document.getElementById('editHandler').value = handler;

    // Set current image
    const currentImage = document.getElementById('currentImage');
    if (image) {
        // Use the full URL path including your app URL
        currentImage.src = `/storage/images/${image}`;
    } else {
        currentImage.src = '/storage/images/default.jpg';
    }

    // Show modal
    modal.classList.remove('hidden');
}

// Dynamically preview the new uploaded image
document.getElementById('editImage').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('currentImage').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

function closeModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');

    // Reset form fields when closing
    document.getElementById('editForm').reset();
    document.getElementById('currentImage').src = '';
}

</script>