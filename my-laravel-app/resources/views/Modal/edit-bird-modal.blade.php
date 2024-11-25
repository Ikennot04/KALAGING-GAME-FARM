<div 
    x-data="editBirdModal()"
    @open-edit-modal.window="openModal($event.detail)"
>
    <!-- Modal Backdrop -->
    <div 
        x-show="open"
        x-transition
        class="fixed inset-0 bg-black bg-opacity-50" 
        @click="open = false"
        style="display: none;"
    ></div>

    <!-- Modal -->
    <div 
        x-show="open"
        x-transition
        class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg"
        @click.outside="open = false"
        style="display: none;"
    >
        <h2 class="text-xl font-bold mb-4">Edit Bird</h2>
        
        <form method="POST" :action="`/birds/${birdId}`" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="bird_id" x-model="birdId">

            <div class="form-group mb-4">
                <label for="breed" class="block mb-1">Breed:</label>
                <input 
                    type="text" 
                    id="breed" 
                    name="breed" 
                    x-model="breed" 
                    class="w-full border rounded px-2 py-1"
                    required
                >
            </div>

            <div class="form-group mb-4">
                <label for="owner" class="block mb-1">Owner:</label>
                <input 
                    type="text" 
                    id="owner" 
                    name="owner" 
                    x-model="owner" 
                    class="w-full border rounded px-2 py-1"
                    required
                >
            </div>

            <div class="form-group mb-4">
                <label for="handler" class="block mb-1">Handler:</label>
                <input 
                    type="text" 
                    id="handler" 
                    name="handler" 
                    x-model="handler" 
                    class="w-full border rounded px-2 py-1"
                    required
                >
            </div>

            <div class="form-group mb-4">
                <label for="image" class="block mb-1">Image:</label>
                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    @change="handleFileUpload($event)"
                    class="w-full"
                >
                <img 
                    :src="imagePreview" 
                    alt="Bird Image" 
                    class="mt-2 max-w-[200px] h-auto"
                >
            </div>

            <div class="flex justify-end space-x-2">
                <button 
                    type="button" 
                    @click="open = false"
                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                >
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                >
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('editBirdModal', () => ({
            open: false,
            birdId: '',
            breed: '',
            owner: '',
            handler: '',
            imagePreview: '',

            openModal(detail) {
                this.open = true;
                this.birdId = detail.id;
                this.breed = detail.breed;
                this.owner = detail.owner;
                this.handler = detail.handler;
                this.imagePreview = detail.image 
                    ? `/storage/images/${detail.image}` 
                    : '/storage/images/default.jpg';
            },

            handleFileUpload(event) {
                const file = event.target.files[0];
                if (!file) return;
                
                const reader = new FileReader();
                const originalBreed = this.breed;

                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                    this.breed = originalBreed;
                };

                reader.readAsDataURL(file);
            }
        }));
    });
</script>

<style>
    /* Keep your existing styles */
</style>
