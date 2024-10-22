'use client'; // Ensure client-side rendering

import React, { useState } from 'react';
import Image from 'next/image'; // Keep the Image import
import CockFights from '../birds/cockfights/page';

// Example component for Cockfights
const CockfightsContent = () => (
  <div className="bg-white p-6 rounded-lg shadow-lg">
    <CockFights />
  </div>
);

function Dashboard() {
  const [activeSection, setActiveSection] = useState('dashboard'); // Default to 'dashboard'

  const renderSection = () => {
    switch (activeSection) {
      case 'dashboard':
        return (
          <div className="relative bg-gradient-to-br from-blue-400 via-purple-300 to-pink-400 p-8 rounded-lg shadow-md overflow-hidden">
            {/* Wavy Background Animation */}
            <div className="absolute inset-0 bg-gradient-to-br from-blue-400 via-purple-300 to-pink-400 opacity-50 animate-wavy"></div>
            <div className="absolute inset-0 bg-gradient-to-br from-pink-400 via-purple-300 to-blue-400 opacity-50 animate-wavy-reverse"></div>

            <div className="relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div className="bg-white p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                <h2 className="text-xl font-semibold text-gray-700">Total Birds</h2>
                <p className="text-2xl font-bold text-gray-900">68</p>
              </div>
              <div className="bg-white p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                <h2 className="text-xl font-semibold text-gray-700">Total Wins</h2>
                <p className="text-2xl font-bold text-gray-900">45</p>
              </div>
              <div className="bg-white p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                <h2 className="text-xl font-semibold text-gray-700">Total Workers</h2>
                <p className="text-2xl font-bold text-gray-900">6</p>
              </div>
            </div>
          </div>
        );
      case 'cockfights':
        return <CockfightsContent />;
      default:
        return <div className="text-gray-700">Select a section from the sidebar</div>;
    }
  };

  return (
    <div className="flex h-screen bg-gray-100">
      {/* Sidebar */}
      <div className="w-64 bg-white shadow-md">
        <div className="flex items-center justify-center h-20 border-b border-gray-200">
          <Image 
            src="/SEIK.gif" // Replace with your logo
            alt="Logo"
            width={200}
            height={150}
          />
        </div>
        <nav className="mt-10">
          <ul>
            <li>
              <button 
                onClick={() => setActiveSection('dashboard')} 
                className={`flex items-center p-2 text-gray-700 hover:bg-gray-200 rounded-md transition-all duration-200 ${activeSection === 'dashboard' && 'bg-gray-300 font-bold'}`}
              >
                Dashboard
              </button>
            </li>
            <li>
              <button 
                onClick={() => setActiveSection('cockfights')} 
                className={`flex items-center p-2 text-gray-700 hover:bg-gray-200 rounded-md transition-all duration-200 ${activeSection === 'cockfights' && 'bg-gray-300 font-bold'}`}
              >
                Cockfights
              </button>
            </li>
            <li>
              <button 
                onClick={() => setActiveSection('settings')} 
                className={`flex items-center p-2 text-gray-700 hover:bg-gray-200 rounded-md transition-all duration-200 ${activeSection === 'settings' && 'bg-gray-300 font-bold'}`}
              >
                Settings
              </button>
            </li>
          </ul>
        </nav>
      </div>

      {/* Main Content */}
      <div className="flex-1 p-10 overflow-y-auto">
        <h1 className="text-3xl font-bold mb-6 text-gray-800">{activeSection === 'dashboard' ? 'Dashboard' : 'Cockfights'}</h1>
        {renderSection()}
      </div>
    </div>
  );
}

export default Dashboard;
