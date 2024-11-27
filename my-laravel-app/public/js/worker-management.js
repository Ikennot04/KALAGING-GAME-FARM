$(document).ready(function() {
    const WorkerManagement = {
        init: function() {
            this.bindEvents();
            console.log('Worker Management initialized');
        },

        bindEvents: function() {
            // Search functionality
            $('#searchInput').on('input', this.debounce(this.performSearch, 300));
            
            // Add worker modal
            $('#addWorkerBtn').on('click', () => $('#addWorkerModal').show());
            $('#cancelAddWorker').on('click', () => $('#addWorkerModal').hide());
            $('#image').on('change', this.handleFileUpload);
            $('#addWorkerForm').on('submit', this.handleAddWorker);

            // Edit worker modal
            $('.edit-worker-btn').on('click', this.openEditModal);
            $('#cancelEditWorker').on('click', () => $('#editWorkerModal').hide());
            $('#editImage').on('change', this.handleEditFileUpload);
            $('#editWorkerForm').on('submit', this.handleEditWorker);

            // Close modals when clicking outside
            $(window).on('click', (e) => {
                if ($(e.target).hasClass('modal-backdrop')) {
                    $('.modal').hide();
                }
            });
        },

        handleFileUpload: function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    $('#imagePreview').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(file);
            }
        },

        handleEditFileUpload: function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    $('#editImagePreview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        },

        openEditModal: function(event) {
            const workerId = $(this).data('worker-id');
            const name = $(this).data('name');
            const position = $(this).data('position');
            const image = $(this).data('image');

            $('#editWorkerForm').attr('action', `/workers/${workerId}`);
            $('#editName').val(name);
            $('#editPosition').val(position);
            $('#editImagePreview').attr('src', image ? `/storage/images/${image}` : '/storage/images/default.jpg');
            $('#editWorkerModal').show();
        },

        handleAddWorker: function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    window.location.reload();
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        },

        handleEditWorker: function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    window.location.reload();
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        },

        performSearch: function() {
            const searchTerm = $('#searchInput').val();
            if (searchTerm.length < 2) {
                $('#searchResults').hide();
                return;
            }

            $.ajax({
                url: `/api/workers/search?search=${encodeURIComponent(searchTerm)}`,
                method: 'GET',
                success: function(data) {
                    if (data.match || (data.related && data.related.length > 0)) {
                        const html = WorkerManagement.buildSearchResultsHtml(data);
                        $('#searchResults').html(html).show();
                    } else {
                        $('#searchResults').hide();
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
            if (data.match) {
                html += `<div class="p-2 hover:bg-gray-100 cursor-pointer" 
                            data-worker-id="${data.match.id}">
                            ${data.match.name} - ${data.match.position}
                        </div>`;
            }
            if (data.related && data.related.length > 0) {
                data.related.forEach(worker => {
                    html += `<div class="p-2 hover:bg-gray-100 cursor-pointer" 
                                data-worker-id="${worker.id}">
                                ${worker.name} - ${worker.position}
                            </div>`;
                });
            }
            return html;
        },

        debounce: function(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }
    };

    WorkerManagement.init();
});
