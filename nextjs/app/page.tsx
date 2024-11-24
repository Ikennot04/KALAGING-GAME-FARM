'use client';

import BirdList from './(pages)/birds/page';

export default function Home() {
  
  
  return (
    <div className="moving-background bg-gradient-to-r from-blue-400 to-blue-600 min-h-screen"> 
    <title>KALAGING GAMEFARM</title>
      <div className="container mx-auto p-6">
        {/* Sort dropdown */}
        <div className="flex justify-between items-center mb-4">
          <div className="mb-4">
            <label className="mr-2">Sort by:</label>
            <select className="bg-gray-200 border border-gray-300 rounded p-2">
              <option value="newest">Newest</option>
              <option value="oldest">Oldest</option>
            </select>

            
          </div>
        </div>

        <div>
          <BirdList />
        </div>
      </div>
    </div>
  );
}
