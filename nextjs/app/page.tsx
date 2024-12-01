'use client';

import BirdList from './(pages)/birds/page';
import { useState } from 'react';

export default function Home() {
  const [sortBy, setSortBy] = useState('newest');

  const handleSort = (value: string) => {
    setSortBy(value);
  };
  
  return (
    <div className="moving-background bg-gradient-to-r from-blue-400 to-blue-600 min-h-screen"> 
    <title>KALAGING GAMEFARM</title>
      <div className="container mx-auto p-6">
        <div className="flex justify-between items-center mb-4">
          <div className="mb-4">
            <label className="mr-2 text-white">Sort by:</label>
            <select 
              className="bg-gray-200 border border-gray-300 rounded p-2"
              value={sortBy}
              onChange={(e) => handleSort(e.target.value)}
            >
              <option value="newest">Newest</option>
              <option value="oldest">Oldest</option>
              <option value="breed">Breed (A-Z)</option>
              <option value="owner">Owner (A-Z)</option>
              <option value="handler">Handler (A-Z)</option>
            </select>
          </div>
        </div>

        <div>
          <BirdList sortBy={sortBy} />
        </div>
      </div>
    </div>
  );
}
