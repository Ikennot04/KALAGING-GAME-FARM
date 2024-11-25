<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
    <div class="container mx-auto px-4 py-8" x-data>
        <h1 class="text-3xl font-bold mb-4 text-center">Dashboard</h1>
        <p class="text-center mb-6">Manage Birds Information</p>
        
        <!-- Add Bird Button -->
        <div class="mb-4 flex justify-end">
            <button 
                onclick="openAddModal()" 
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm flex items-center">
                <span class="mr-1">+</span> Add Bird
            </button>
        </div>
        
        <!-- Display birds -->
        <div>
            @if(empty($birds))
                <p class="text-center text-gray-500">No birds found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse border border-gray-300 text-left">
                        <tbody>
                            @foreach($birds as $bird)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2">
                                    @if($bird->getImage() && $bird->getImage() !== 'default.jpg' && Storage::disk('public')->exists('images/' . $bird->getImage()))
                                        <img src="{{ Storage::url('images/' . $bird->getImage()) }}" 
                                             alt="Bird Image" 
                                             class="w-16 h-16 object-cover">
                                    @else
                                        <img src="{{ Storage::url('images/default.jpg') }}" 
                                             alt="Default Bird Image" 
                                             class="w-16 h-16 object-cover">
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2">{{ $bird->getBreed() }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $bird->getOwner() }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $bird->getHandler() }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <button 
                                        type="button"
                                        @click="$dispatch('open-edit-modal', {
                                            id: '{{ $bird->getId() }}',
                                            breed: '{{ $bird->getBreed() }}',
                                            owner: '{{ $bird->getOwner() }}',
                                            handler: '{{ $bird->getHandler() }}',
                                            image: '{{ $bird->getImage() }}'
                                        })"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm"
                                    >
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Include the modals -->
        @include('Modal.edit-bird-modal')
        @include('Modal.add-bird-modal')
    </div>
</body>
</html>