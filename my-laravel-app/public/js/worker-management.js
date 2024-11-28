$(document).ready(function() {
    const WorkerManagement = {
        init: function() {
            this.bindEvents();
            console.log('Worker Management initialized');
        },

        bindEvents: function() {
            $('#searchInput').on('input', (e) => {
                this.performSearch();
            });

            $(document).on('click', '.search-result-item', function() {
                const workerId = $(this).data('worker-id');
                WorkerManagement.highlightAndScrollTo(workerId);
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
