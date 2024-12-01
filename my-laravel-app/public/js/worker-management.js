$(document).ready(function() {
    const WorkerManagement = {
        init: function() {
            this.bindEvents();
            
        },

        bindEvents: function() {
            $('#searchInput').on('input', (e) => {
                this.performSearch();
            });

            $(document).on('click', '.search-result-item', function() {
                const workerId = $(this).data('worker-id');
                WorkerManagement.highlightAndScrollTo(workerId);
            });

            // Add Worker button click event
            $('#addWorkerBtn').on('click', function() {
                $('#addWorkerModal').show();
            });

            // Cancel button in Add Worker modal
            $('#addWorkerModal').find('button[type="button"]').on('click', function() {
                $('#addWorkerModal').hide();
            });

            // Close modal when clicking outside
            $('#addWorkerModal').on('click', function(e) {
                if (e.target === this) {
                    $(this).hide();
                }
            });

            // Edit Worker button click event
            $('.edit-worker-btn').on('click', function() {
                const workerId = $(this).data('worker-id');
                const name = $(this).data('name');
                const position = $(this).data('position');
                const image = $(this).data('image');

                // Populate the edit form
                $('#editWorkerForm').attr('action', `/workers/${workerId}`);
                $('#editName').val(name);
                $('#editPosition').val(position);
                $('#editImagePreview').attr('src', `/storage/images/${image}`);

                // Show the modal
                $('#editWorkerModal').show();
            });

            // Cancel button in Edit Worker modal
            $('#cancelEditWorker').on('click', function() {
                $('#editWorkerModal').hide();
            });

            // Close edit modal when clicking outside
            $('#editWorkerModal').on('click', function(e) {
                if (e.target === this) {
                    $(this).hide();
                }
            });

            // Preview image before upload in edit modal
            $('#editImage').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#editImagePreview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Handle delete button clicks
            $('.delete-worker-btn').on('click', function() {
                const workerId = $(this).data('worker-id');
                if (confirm('Are you sure you want to archive this worker?')) {
                    $.ajax({
                        url: `/workers/${workerId}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                window.location.reload();
                            }
                        },
                        error: function(error) {
                            alert('Failed to archive worker');
                        }
                    });
                }
            });

            // Handle restore button clicks (for archive page)
            $('.restore-worker-btn').on('click', function() {
                const workerId = $(this).data('worker-id');
                if (confirm('Are you sure you want to restore this worker?')) {
                    $.ajax({
                        url: `/workers/${workerId}/restore`,
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
                }
            });
        },

        performSearch: function() {
            const searchTerm = $('#searchInput').val().trim();
            if (searchTerm.length < 1) {
                $('#searchResults').hide();
                return;
            }

            // Check if search term is a number (ID search)
            const isIdSearch = !isNaN(searchTerm) && searchTerm.length > 0;

            $.ajax({
                url: `/api/workers/search?search=${encodeURIComponent(searchTerm)}&type=${isIdSearch ? 'id' : 'text'}`,
                method: 'GET',
                success: function(data) {
                    if (data.match || (data.related && data.related.length > 0)) {
                        const html = WorkerManagement.buildSearchResultsHtml(data);
                        $('#searchResults').html(html).show();
                    } else {
                        $('#searchResults').html('<div class="p-2 text-gray-500">No results found</div>').show();
                    }
                },
                error: function(error) {
                    console.error('Search error:', error);
                    $('#searchResults').hide();
                }
            });
        },

        buildSearchResultsHtml: function(data) {
            let html = '';
            
            // Exact match section
            if (data.match) {
                html += `
                    <div class="p-3 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-600 mb-2">Exact Match</h3>
                        <div class="search-result-item flex items-center space-x-3 hover:bg-gray-100 p-2 rounded cursor-pointer" 
                             data-worker-id="${data.match.id}">
                            <img src="/storage/images/${data.match.image || 'default.jpg'}" 
                                 alt="${data.match.name}"
                                 class="h-10 w-10 rounded-full object-cover">
                            <div>
                                <div class="font-medium">${data.match.name}</div>
                                <div class="text-sm text-gray-500">${data.match.position}</div>
                                <div class="text-xs text-gray-400">ID: ${data.match.id}</div>
                            </div>
                        </div>
                    </div>`;
            }

            // Related results section
            if (data.related && data.related.length > 0) {
                html += `
                    <div class="p-3">
                        <h3 class="text-sm font-semibold text-gray-600 mb-2">
                            ${data.match ? 'Related Results' : 'Search Results'}
                        </h3>
                        <div class="space-y-2">`;
                
                data.related.forEach(worker => {
                    html += `
                        <div class="search-result-item flex items-center space-x-3 hover:bg-gray-100 p-2 rounded cursor-pointer" 
                             data-worker-id="${worker.id}">
                            <img src="/storage/images/${worker.image || 'default.jpg'}" 
                                 alt="${worker.name}"
                                 class="h-10 w-10 rounded-full object-cover">
                            <div>
                                <div class="font-medium">${worker.name}</div>
                                <div class="text-sm text-gray-500">${worker.position}</div>
                                <div class="text-xs text-gray-400">ID: ${worker.id}</div>
                            </div>
                        </div>`;
                });

                html += `
                        </div>
                    </div>`;
            }

            return html;
        },

        highlightAndScrollTo: function(workerId) {
            const row = $(`#worker-row-${workerId}`);
            if (row.length) {
                row.addClass('bg-yellow-100');
                $('html, body').animate({
                    scrollTop: row.offset().top - (window.innerHeight / 2)
                }, 500);
                
                setTimeout(() => {
                    row.removeClass('bg-yellow-100');
                }, 2000);
                
                $('#searchResults').hide();
            }
        }
    };

    WorkerManagement.init();
});
