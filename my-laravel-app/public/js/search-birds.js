$(document).ready(function() {
    const BirdManagement = {
        init: function() {
            this.bindEvents();
            console.log('Bird Management initialized with jQuery version:', $.fn.jquery);
        },

        bindEvents: function() {
            console.log('Binding search input event');
            $('#searchInput').on('input', (e) => {
                console.log('Search input changed:', e.target.value);
                this.performSearch();
            });

            $(document).on('click', '.search-result-item', function() {
                const birdId = $(this).data('bird-id');
                BirdManagement.highlightAndScrollTo(birdId);
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
                    console.log('Search results:', data); // Debug log
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
