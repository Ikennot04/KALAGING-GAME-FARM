@extends('layouts.app')

@section('title', 'Archived Workers')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold text-gray-800 text-center mb-4">Archived Workers</h1>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($workers as $worker)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $worker->getId() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="{{ asset('storage/images/' . $worker->getImage()) }}" 
                             alt="Worker Image" 
                             class="h-10 w-10 rounded-full object-cover">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $worker->getName() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $worker->getPosition() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button 
                            class="text-indigo-600 hover:text-indigo-900 restore-worker-btn"
                            data-worker-id="{{ $worker->getId() }}"
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

<div id="restore-worker-modal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm w-full">
        <h3 class="text-xl font-semibold text-gray-800">Confirm Restore</h3>
        <p class="mt-2 text-sm text-gray-600">Are you sure you want to restore this worker?</p>
        <div class="mt-4 flex justify-end">
            <button id="cancel-worker-restore" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                Cancel
            </button>
            <button id="confirm-worker-restore" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Confirm
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    let workerIdToRestore = null;

    // Handle restore button clicks
    $('.restore-worker-btn').on('click', function() {
        workerIdToRestore = $(this).data('worker-id');
        $('#restore-worker-modal').removeClass('hidden');
    });

    // Handle modal cancel button
    $('#cancel-worker-restore').on('click', function() {
        $('#restore-worker-modal').addClass('hidden');
        workerIdToRestore = null;
    });

    // Handle modal confirm button
    $('#confirm-worker-restore').on('click', function() {
        if (!workerIdToRestore) return;
        
        $.ajax({
            url: `/workers/${workerIdToRestore}/restore`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    window.location.reload();
                }
            },
            error: function(error) {
                alert('Failed to restore worker');
            }
        });
    });

    // Close modal when clicking outside
    $('#restore-worker-modal').on('click', function(e) {
        if (e.target === this) {
            $(this).addClass('hidden');
            workerIdToRestore = null;
        }
    });
});
</script>
@endsection 