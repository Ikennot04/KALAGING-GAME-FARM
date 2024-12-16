'use client'
import { useState, useCallback } from 'react';
import { useRouter } from 'next/navigation';
import debounce from 'lodash/debounce';

interface SearchResult {
  match: Bird | null;
  related: Bird[];
}

interface Bird {
  id: number;
  breed: string;
  owner: string;
  handler: string;
  image: string;
  created_at: string;
}

export default function Search() {
  const router = useRouter();
  const [searchTerm, setSearchTerm] = useState('');
  const [searchResults, setSearchResults] = useState<SearchResult>({ match: null, related: [] });
  const [showResults, setShowResults] = useState(false);

  const debouncedSearch = useCallback(
    debounce(async (term: string) => {
      if (term.length < 2) {
        setShowResults(false);
        return;
      }

      try {
        const response = await fetch(
          `http://localhost:8000/api/birds/search?search=${encodeURIComponent(term)}`
        );
        
        if (!response.ok) throw new Error('Search failed');
        
        const data = await response.json();
        console.log('Raw search results:', data);

        setSearchResults({
            match: data.match,
            related: data.related || []
        });
        setShowResults(true);
      } catch (error) {
        console.error('Search error:', error);
        setSearchResults({ match: null, related: [] });
        setShowResults(false);
      }
    }, 300),
    []
  );

  const handleSearchChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const value = e.target.value;
    setSearchTerm(value);
    debouncedSearch(value);
  };

  const handleBirdClick = (birdId: number) => {
    router.push(`/birds/${birdId}`);
    setShowResults(false);
  };

  const handleClickOutside = () => {
    setShowResults(false);
  };

  return (
    <div className="relative">
      <input
        type="text"
        value={searchTerm}
        onChange={handleSearchChange}
        placeholder="Search birds..."
        className="px-4 py-2 w-64 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow duration-200"
      />
      
      {showResults && (
        <div 
          className="absolute z-50 w-full mt-1 bg-white rounded-md shadow-lg border border-gray-200 max-h-96 overflow-y-auto"
          onBlur={handleClickOutside}
        >
          {searchResults.match && (
            <div key="exact-match" className="p-3 border-b border-gray-200">
              <h3 className="text-sm font-semibold text-gray-600 mb-2">Exact Match</h3>
              <div 
                onClick={() => handleBirdClick(searchResults.match!.id)}
                className="cursor-pointer"
              >
                <SearchResultItem bird={searchResults.match} />
              </div>
            </div>
          )}
          
          {searchResults.related && searchResults.related.length > 0 && (
            <div key="related-results" className="p-3">
              <h3 className="text-sm font-semibold text-gray-600 mb-2">
                {searchResults.match ? 'Related Results' : 'Search Results'}
              </h3>
              <div className="space-y-2">
                {searchResults.related.map((bird) => (
                  <div 
                    key={`related-${bird.id}`}
                    onClick={() => handleBirdClick(bird.id)}
                    className="cursor-pointer"
                  >
                    <SearchResultItem bird={bird} />
                  </div>
                ))}
              </div>
            </div>
          )}
          
          {!searchResults.match && (!searchResults.related || searchResults.related.length === 0) && (
            <div key="no-results" className="p-3 text-gray-500">No results found</div>
          )}
        </div>
      )}
    </div>
  );
}

function SearchResultItem({ bird }: { bird: Bird }) {
  return (
    <div className="flex items-center space-x-3 hover:bg-gray-100 p-2 rounded">
      <img
        src={`http://localhost:8000/storage/images/${bird.image}`}
        alt={bird.breed}
        className="h-10 w-10 rounded-full object-cover"
      />
      <div>
        <div className="font-medium">{bird.breed}</div>
        <div className="text-sm text-gray-500">
          Owner: {bird.owner} | Handler: {bird.handler}
        </div>
      </div>
    </div>
  );
}