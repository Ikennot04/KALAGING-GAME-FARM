function searchBirds() {
    return {
        searchTerm: '',
        searchResults: {
            match: null,
            related: []
        },
        showResults: false,
        highlightedId: null,
        async performSearch() {
            if (this.searchTerm.length < 1) {
                this.searchResults = { match: null, related: [] };
                this.showResults = false;
                return;
            }

            try {
                const response = await fetch(`/birds/search?search=${encodeURIComponent(this.searchTerm)}`);
                if (!response.ok) throw new Error('Search failed');
                
                this.searchResults = await response.json();
                this.showResults = true;
            } catch (error) {
                console.error('Search error:', error);
                this.searchResults = { match: null, related: [] };
                this.showResults = false;
            }
        },
        highlightAndScrollTo(id) {
            // Remove previous highlight
            if (this.highlightedId) {
                const prevRow = document.getElementById(`bird-row-${this.highlightedId}`);
                if (prevRow) {
                    prevRow.classList.remove('bg-yellow-100');
                }
            }

            // Add new highlight
            const row = document.getElementById(`bird-row-${id}`);
            if (row) {
                row.classList.add('bg-yellow-100');
                row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                this.highlightedId = id;
            }

            // Close the dropdown
            this.showResults = false;
            this.searchTerm = '';
        },
        getImageUrl(imageName) {
            if (!imageName || imageName === 'default.jpg') {
                return '/storage/images/default.jpg';
            }
            return `/storage/images/${imageName}`;
        }
    }
} 