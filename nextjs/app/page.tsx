'use client';
import React, { useState } from 'react';
import BirdList from './(pages)/birds/page';
import AddBirdni from './(pages)/birds/(modals)/add/page';

export default function Home() {
  const [isOpen, setIsOpen] = useState(false);
  
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

            <button
              className='bg-blue-600 text-white px-4 py-2 rounded-md ml-4'
              onClick={() => setIsOpen(true)}
            >
              <span className='material-icons'>add</span>
              <span className='ml-2'>Add New Bird</span>
            </button>

            {isOpen && (
              <div className="fixed inset-0 bg-black bg-opacity-90 flex justify-center items-center">
                <div className="bg-white p-6 rounded-lg">
                  <AddBirdni />

                  <button
                    className="bg-red-500 text-white px-4 py-2 rounded-md mt-4"
                    onClick={() => setIsOpen(false)}
                  >
                    Close 
                  </button>

                  <button 
                    className="bg-blue-500 text-white flex space-x-6 px-4 py-2 rounded-md mt-4"
                    onClick={() => setIsOpen(false)}
                  >
                    OK
                  </button>
                </div>
              </div>
            )}
          </div>
        </div>

        <div>
          <BirdList />
        </div>
      </div>
    </div>
  );
}
