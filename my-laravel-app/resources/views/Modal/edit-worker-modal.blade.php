<div 
    x-data="editWorkerModal()"
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
        <h2 class="text-xl font-bold mb-4">Edit Worker</h2>
        
        <form method="POST" :action="`/workers/${workerId}`" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="worker_id" x-model="workerId">

            <div class="form-group mb-4">
                <label for="name" class="block mb-1">Name:</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    x-model="name" 
                    class="w-full border rounded px-2 py-1"
                    required
                >
            </div>

            <div class="form-group mb-4">
                <label for="position" class="block mb-1">Position:</label>
                <input 
                    type="text" 
                    id="position" 
                    name="position" 
                    x-model="position" 
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
                    alt="Worker Image" 
                    class="mt-2 max-w-[200px] h-auto"
                >
            </div>

            <div class="flex justify-end space-x-2">
                <button 
                    type="button" 
                    @click="open = false"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
                >
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded"
                >
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('editWorkerModal', () => ({
            open: false,
            workerId: '',
            name: '',
            position: '',
            imagePreview: '',

            openModal(detail) {
                this.open = true;
                this.workerId = detail.id;
                this.name = detail.name;
                this.position = detail.position;
                this.imagePreview = detail.image 
                    ? `/storage/images/${detail.image}` 
                    : '/images/default.jpg';
            },

            handleFileUpload(event) {
                const file = event.target.files[0];
                if (!file) return;
                
                const reader = new FileReader();
                const originalName = this.name;

                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                    this.name = originalName;
                };

                reader.readAsDataURL(file);
            },

            getImageUrl(image) {
                if (!image) return '/images/default.jpg';
                try {
                    return `/storage/images/${image}`;
                } catch (error) {
                    return '/images/default.jpg';
                }
            }
        }));
    });
</script>
