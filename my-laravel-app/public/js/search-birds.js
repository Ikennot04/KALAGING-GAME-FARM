$(document).ready(function() {
    const BirdManagement = {
        init: function() {
            this.bindEvents();
            
        },

        bindEvents: function() {
            
            $('#searchInput').on('input', (e) => {
                
                this.performSearch();
            });

            $(document).on('click', '.search-result-item', function() {
                const birdId = $(this).data('bird-id');
                BirdManagement.highlightAndScrollTo(birdId);
            });

            $('#addBirdBtn').on('click', function() {
                $('#addBirdModal').removeClass('hidden');
            });

            $('#cancelAddBird').on('click', function() {
                $('#addBirdModal').addClass('hidden');
                $('#imagePreview').addClass('hidden');
            });

            $('#image').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result).removeClass('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            $('.edit-bird-btn').on('click', function() {
                const birdId = $(this).data('bird-id');
                const breed = $(this).data('breed');
                const owner = $(this).data('owner');
                const handler = $(this).data('handler');
                const image = $(this).data('image');

                $('#editBirdForm').attr('action', `/birds/${birdId}`);
                
                $('#editBreed').val(breed);
                $('#editOwner').val(owner);
                $('#editHandler').val(handler);
                if (image) {
                    $('#editImagePreview').attr('src', `/storage/images/${image}`).removeClass('hidden');
                }

                $('#editBirdModal').removeClass('hidden');
            });

            $('#cancelEditBird').on('click', function() {
                $('#editBirdModal').addClass('hidden');
            });

            $('#editImage').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#editImagePreview').attr('src', e.target.result).removeClass('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            $('.fixed').on('click', function(e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                }
            });

            $('#editBirdForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const formData = new FormData(this);
                formData.append('_method', 'PUT');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.message) {
                            $('#editBirdModal').addClass('hidden');
                            window.location.reload();
                        }
                    },
                    error: function(error) {
                        console.error('Update error:', error.responseJSON?.error || 'Unknown error occurred');
                        alert(error.responseJSON?.error || 'Failed to update bird. Please try again.');
                    }
                });
            });

            // Handle delete button clicks
            let birdIdToArchive = null;

            $('.delete-bird-btn').on('click', function() {
                birdIdToArchive = $(this).data('bird-id');
                $('#archive-modal').removeClass('hidden');
            });

            // Handle modal cancel button
            $('#cancel-archive').on('click', function() {
                $('#archive-modal').addClass('hidden');
                birdIdToArchive = null;
            });

            // Handle modal confirm button
            $('#confirm-archive').on('click', function() {
                if (!birdIdToArchive) return;
                
                $.ajax({
                    url: `/birds/${birdIdToArchive}`,
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
                        alert('Failed to archive bird');
                    }
                });
            });

            // Close modal when clicking outside
            $('#archive-modal').on('click', function(e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                    birdIdToArchive = null;
                }
            });

            // Handle restore button clicks (for archive page)
            $('.restore-bird-btn').on('click', function() {
                const birdId = $(this).data('bird-id');
                if (confirm('Are you sure you want to restore this bird?')) {
                    $.ajax({
                        url: `/birds/${birdId}/restore`,
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
                            alert('Failed to restore bird');
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
                url: `/birds/search?search=${encodeURIComponent(searchTerm)}&type=${isIdSearch ? 'id' : 'text'}`,
                method: 'GET',
                success: function(data) {
                    
                    if (data.match || (data.related && data.related.length > 0)) {
                        const html = BirdManagement.buildSearchResultsHtml(data);
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
            
            if (data.match) {
                html += `
                    <div class="p-3 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-600 mb-2">Exact Match</h3>
                        <div class="search-result-item flex items-center space-x-3 hover:bg-gray-100 p-2 rounded cursor-pointer" 
                             data-bird-id="${data.match.id}">
                            <img src="/storage/images/${data.match.image || 'default.jpg'}" 
                                 alt="${data.match.breed}"
                                 class="h-10 w-10 rounded-full object-cover">
                            <div>
                                <div class="font-medium">${data.match.breed}</div>
                                <div class="text-sm text-gray-500">
                                    Owner: ${data.match.owner} | Handler: ${data.match.handler}
                                </div>
                                <div class="text-xs text-gray-400">ID: ${data.match.id}</div>
                            </div>
                        </div>
                    </div>`;
            }

            if (data.related && data.related.length > 0) {
                html += `
                    <div class="p-3">
                        <h3 class="text-sm font-semibold text-gray-600 mb-2">
                            ${data.match ? 'Related Results' : 'Search Results'}
                        </h3>
                        <div class="space-y-2">`;
                
                data.related.forEach(bird => {
                    html += `
                        <div class="search-result-item flex items-center space-x-3 hover:bg-gray-100 p-2 rounded cursor-pointer" 
                             data-bird-id="${bird.id}">
                            <img src="/storage/images/${bird.image || 'default.jpg'}" 
                                 alt="${bird.breed}"
                                 class="h-10 w-10 rounded-full object-cover">
                            <div>
                                <div class="font-medium">${bird.breed}</div>
                                <div class="text-sm text-gray-500">
                                    Owner: ${bird.owner} | Handler: ${bird.handler}
                                </div>
                                <div class="text-xs text-gray-400">ID: ${bird.id}</div>
                            </div>
                        </div>`;
                });

                html += `
                        </div>
                    </div>`;
            }

            return html;
        },

        highlightAndScrollTo: function(birdId) {
            const row = $(`#bird-row-${birdId}`);
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

    BirdManagement.init();
});
