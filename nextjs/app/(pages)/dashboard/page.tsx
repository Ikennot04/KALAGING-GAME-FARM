'use client'; // Ensure client-side rendering

import React, { useState, useEffect } from 'react';
import Image from 'next/image'; // Keep the Image import
import CockFights from '../birds/cockfights/page';

// Example component for Cockfights
const CockfightsContent = () => (
  <div className="bg-white p-6 rounded-lg shadow-lg">
    <CockFights />
  </div>
);

function Dashboard() {
  const [activeSection, setActiveSection] = useState('dashboard'); 
  const [stats, setStats] = useState({
    birdCount: 0,
    workerCount: 0
  });

  useEffect(() => {
    const fetchStats = async () => {
      try {
        const response = await fetch('http://localhost:8000/api/dashboard/stats');
        if (!response.ok) throw new Error('Failed to fetch stats');
        const data = await response.json();
        setStats(data);
      } catch (error) {
        console.error('Error fetching stats:', error);
      }
    };

    fetchStats();
  }, []);

  const renderSection = () => {
    switch (activeSection) {
      case 'dashboard':
        return (
          <div className="relative bg-gradient-to-br from-blue-400 via-purple-300 to-pink-400 p-8 rounded-lg shadow-xl overflow-hidden">
            
            <div className="absolute inset-0 bg-gradient-to-br from-blue-400 via-purple-300 to-pink-400 opacity-20 animate-wavy"></div>
            <div className="absolute inset-0 bg-gradient-to-br from-pink-400 via-purple-300 to-blue-400 opacity-20 animate-wavy-reverse"></div>

            <div className="relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              <div className="bg-white p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                <h2 className="text-xl font-semibold text-gray-700">Total Birds</h2>
                <p className="text-4xl font-bold text-gray-900">{stats.birdCount}</p>
              </div>
              
              <div className="bg-white p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                <h2 className="text-xl font-semibold text-gray-700">Total Workers</h2>
                <p className="text-4xl font-bold text-gray-900">{stats.workerCount}</p>
              </div>
            </div>

            <div className="mt-8">
              <h2 className="text-2xl font-semibold text-gray-700 mb-6">Handlers</h2>
              <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div className="bg-white p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                  <h3 className="text-xl font-semibold text-gray-700">Fausto</h3>
                  <p className="text-xl font-semibold text-gray-700">35 Chickens</p>
                </div>
                <div className="bg-white p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                  <h3 className="text-xl font-semibold text-gray-700">Keiry</h3>
                  <p className="text-xl font-semibold text-gray-700">80 Chickens</p>
                </div>
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
      <div className="w-64 bg-white shadow-xl">
        <div className="flex items-center justify-center h-24 border-b border-gray-200">
          <Image 
            src="/SEIK.gif" // Replace with your logo
            alt="Logo"
            width={200}
            height={150}
            className="object-contain"
          />
        </div>
        <nav className="mt-10">
          <ul>
            <li>
              <button 
                onClick={() => setActiveSection('dashboard')} 
                className={`flex items-center p-3 text-lg text-gray-700 hover:bg-gray-200 rounded-md transition-all duration-200 ${activeSection === 'dashboard' ? 'bg-gray-300 font-bold' : 'bg-white'}`}
              >
                Dashboard
              </button>
            </li>
            <li>
              <button 
                onClick={() => setActiveSection('cockfights')} 
                className={`flex items-center p-3 text-lg text-gray-700 hover:bg-gray-200 rounded-md transition-all duration-200 ${activeSection === 'cockfights' ? 'bg-gray-300 font-bold' : 'bg-white'}`}
              >
                Cockfights
              </button>
            </li>
          </ul>
        </nav>
      </div>

      {/* Main Content */}
      <div className="flex-1 p-8 overflow-y-auto">
        <h1 className="text-4xl font-bold mb-6 text-gray-800">{activeSection === 'dashboard' ? 'Dashboard' : 'Cockfights'}</h1>
        {renderSection()}
      </div>
    </div>
  );
}

export default Dashboard;
