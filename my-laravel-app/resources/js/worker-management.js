document.addEventListener('alpine:init', () => {
    Alpine.data('workerManagement', () => ({
        searchTerm: '',
        searchResults: {
            match: null,
            related: []
        },

        async performSearch() {
            if (!this.searchTerm) {
                this.searchResults = { match: null, related: [] };
                return;
            }

            try {
                const response = await fetch(`/api/workers/search?search=${this.searchTerm}`);
                const data = await response.json();
                this.searchResults = data;
            } catch (error) {
                console.error('Search failed:', error);
            }
        },

        getImageUrl(image) {
            if (!image) return '/images/default.jpg';
            try {
                return `/storage/images/${image}`;
            } catch (error) {
                return '/images/default.jpg';
            }
        },

        highlightAndScrollTo(workerId) {
            const row = document.getElementById(`worker-row-${workerId}`);
            if (!row) return;

            // Remove any existing highlights
            document.querySelectorAll('tr.bg-yellow-100').forEach(el => {
                el.classList.remove('bg-yellow-100');
            });

            // Add highlight to the target row
            row.classList.add('bg-yellow-100');
            row.scrollIntoView({ behavior: 'smooth', block: 'center' });

            // Remove highlight after 2 seconds
            setTimeout(() => {
                row.classList.remove('bg-yellow-100');
            }, 2000);

            // Clear search results
            this.searchResults = { match: null, related: [] };
            this.searchTerm = '';
        }
    }));
});
