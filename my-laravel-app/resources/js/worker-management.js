if (typeof Alpine !== 'undefined') {
    Alpine.data('workerManagement', () => ({
        formData: {
            name: '',
            position: '',
            image: null
        },
        searchTerm: '',
        searchResults: {
            match: null,
            related: []
        },
        showResults: false,
        showAddModal: false,
        imagePreview: '',

        init() {
            console.log('Component mounted, formData initialized:', this.formData);
        },

        handleFileUpload(event) {
            this.formData.image = event.target.files[0];
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imagePreview = e.target.result;
            };
            if (this.formData.image) {
                reader.readAsDataURL(this.formData.image);
            }
        },

        async performSearch() {
            if (this.searchTerm.length < 2) {
                this.searchResults = { match: null, related: [] };
                this.showResults = false;
                return;
            }

            try {
                const response = await fetch(`/api/workers/search?search=${encodeURIComponent(this.searchTerm)}`);
                if (!response.ok) throw new Error('Search failed');
                
                const data = await response.json();
                this.searchResults = data;
                this.showResults = true;
            } catch (error) {
                console.error('Search error:', error);
                this.searchResults = { match: null, related: [] };
                this.showResults = false;
            }
        },

        getImageUrl(image) {
            return image ? `/storage/images/${image}` : '/storage/images/default.jpg';
        },

        highlightAndScrollTo(workerId) {
            const row = document.getElementById(`worker-row-${workerId}`);
            if (!row) return;

            row.classList.add('bg-yellow-100');
            row.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            setTimeout(() => {
                row.classList.remove('bg-yellow-100');
            }, 2000);

            this.showResults = false;
        }
    }))
}
