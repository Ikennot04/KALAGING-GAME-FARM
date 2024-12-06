@extends('layouts.app')

@section('title', 'Archived Birds')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold text-gray-800 text-center mb-6">Archived Birds</h1>
    
    <!-- Table displaying the archived birds -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Breed</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Handler</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($birds as $bird)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $bird->getId() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="{{ asset('storage/images/' . $bird->getImage()) }}" 
                             alt="Bird Image" 
                             class="h-10 w-10 rounded-full object-cover">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $bird->getBreed() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $bird->getOwner() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $bird->getHandler() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button 
                            class="text-indigo-600 hover:text-indigo-900 restore-bird-btn"
                            data-bird-id="{{ $bird->getId() }}"
                        >
                            Restore
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for confirmation -->
<div id="restore-modal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm w-full">
        <h3 class="text-xl font-semibold text-gray-800">Confirm Restore</h3>
        <p class="mt-2 text-sm text-gray-600">Are you sure you want to restore this bird?</p>
        <div class="mt-4 flex justify-end">
            <button id="cancel-btn" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                Cancel
            </button>
            <button id="confirm-btn" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Confirm
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let birdIdToRestore = null;

    // Handle restore button clicks
    document.querySelectorAll('.restore-bird-btn').forEach(button => {
        button.addEventListener('click', function() {
            birdIdToRestore = this.dataset.birdId; // Set the birdId to restore
            document.getElementById('restore-modal').classList.remove('hidden'); // Show the modal
        });
    });

    // Cancel restore action
    document.getElementById('cancel-btn').addEventListener('click', function() {
        document.getElementById('restore-modal').classList.add('hidden'); // Hide the modal
        birdIdToRestore = null; // Reset the birdId
    });

    // Confirm restore action
    document.getElementById('confirm-btn').addEventListener('click', function() {
        if (birdIdToRestore) {
            fetch(`/birds/${birdIdToRestore}/restore`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload(); // Reload the page after successful restore
                } else {
                    alert('Failed to restore bird');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to restore bird');
            });
        }
    });
});
</script>
@endsection
