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
        {/* Header Section */}
        <div className="text-center mb-6">
          <h1 className="text-4xl font-extrabold text-white mb-2">KALAGING GAMEFARM</h1>
          <p className="text-lg text-white opacity-80">Explore our collection of birds </p>
        </div>

        {/* Sorting Controls */}
        <div className="flex justify-between items-center mb-6">
          <div className="flex items-center space-x-4">
            <label className="text-white font-medium">Sort by:</label>
            <select
              className="bg-white text-gray-700 border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 transition-all duration-200"
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

        {/* Bird List Display */}
        <div className="bg-white rounded-lg shadow-md p-4">
          <BirdList sortBy={sortBy} />
        </div>
      </div>
    </div>
  );
}
