'use client'; // Ensure client-side rendering

import React, { useState, useEffect } from 'react';
import Image from 'next/image';
import { Bar } from 'react-chartjs-2';
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  BarElement,
  Title,
  Tooltip,
  Legend,
  ChartOptions,
} from 'chart.js';
import Cockfights from '../birds/cockfights/page'; // Import the Cockfights component

// Register required components for Chart.js
ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

function Dashboard() {
  const [activeSection, setActiveSection] = useState('dashboard');
  const [stats, setStats] = useState({
    birdCount: 0,
    workerCount: 0,
  });
  const [error, setError] = useState<string | null>(null);

  // Function to fetch dashboard stats
  const fetchStats = async () => {
    try {
      const response = await fetch('http://localhost:8000/api/dashboard/stats');
      if (!response.ok) throw new Error('Failed to fetch stats');
      const data = await response.json();
      setStats(data);
      setError(null); // Clear any previous errors
    } catch (error) {
      console.error('Error fetching stats:', error);
      setError('Failed to fetch dashboard data');
    }
  };

  // Initial fetch and setup polling
  useEffect(() => {
    // Fetch immediately when component mounts
    fetchStats();

    // Set up polling every 5 seconds
    const intervalId = setInterval(fetchStats, 5000);

    // Cleanup function to clear interval when component unmounts
    return () => clearInterval(intervalId);
  }, []); // Empty dependency array means this effect runs once on mount

  const renderSection = () => {
    switch (activeSection) {
      case 'dashboard':
        const data = {
          labels: ['Birds', 'Workers'],
          datasets: [
            {
              label: 'Total count of Birds',
              data: [stats.birdCount, null],
              backgroundColor: 'rgba(75, 192, 192, 0.8)',
              borderColor: 'rgba(75, 192, 192, 1)',
              borderWidth: 1,
            },
            {
              label: 'Total count of Workers',
              data: [null, stats.workerCount],
              backgroundColor: 'rgba(255, 99, 132, 0.8)',
              borderColor: 'rgba(255, 99, 132, 1)',
              borderWidth: 1,
            },
          ],
        };

        const options: ChartOptions<'bar'> = {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true,
              position: 'top',
              labels: {
                font: {
                  size: 14,
                },
              },
            },
            tooltip: {
              enabled: true,
              backgroundColor: 'rgba(0,0,0,0.8)',
              titleColor: '#ffffff',
              bodyColor: '#ffffff',
              borderWidth: 1,
              borderColor: '#ffffff',
            },
          },
          scales: {
            x: {
              beginAtZero: true,
              grid: {
                display: false,
              },
              ticks: {
                font: {
                  size: 12,
                },
              },
            },
            y: {
              beginAtZero: true,
              ticks: {
                font: {
                  size: 12,
                },
              },
              grid: {
                color: '#e4e4e4',
              },
            },
          },
        };

        return (
          <div className="flex flex-col items-center bg-gradient-to-br from-blue-400 via-purple-300 to-pink-400 p-8 rounded-lg shadow-2xl">
            {error ? (
              <div className="text-red-600 bg-red-100 p-4 rounded-lg mb-4">
                {error}
              </div>
            ) : null}
            
            {/* Stats Cards */}
            <div className="grid grid-cols-2 gap-6 w-full mb-8">
              <div className="bg-white p-6 rounded-lg shadow-md">
                <h3 className="text-xl font-semibold text-gray-800 mb-2">
                  Total Birds
                </h3>
                <p className="text-3xl font-bold text-blue-600">
                  {stats.birdCount}
                </p>
              </div>
              <div className="bg-white p-6 rounded-lg shadow-md">
                <h3 className="text-xl font-semibold text-gray-800 mb-2">
                  Total Workers
                </h3>
                <p className="text-3xl font-bold text-pink-600">
                  {stats.workerCount}
                </p>
              </div>
            </div>

            {/* Chart */}
            <div className="w-full bg-white p-6 rounded-lg shadow-md">
              <h2 className="text-2xl font-semibold mb-4 text-gray-800">
                Statistics Overview
              </h2>
              <div style={{ height: '400px' }}>
                <Bar data={data} options={options} />
              </div>
            </div>
          </div>
        );

      case 'cockfights':
        return <Cockfights />;

      default:
        return (
          <div className="text-gray-700 text-center">
            Please select a section from the sidebar.
          </div>
        );
    }
  };

  return (
    <div className="flex h-screen bg-gray-50">
      {/* Sidebar */}
      <div className="w-64 bg-white shadow-xl">
        <div className="flex items-center justify-center h-24 border-b border-gray-200">
          <Image
            src="/SEIK.gif"
            alt="Logo"
            width={180}
            height={120}
            className="object-contain"
          />
        </div>
        <nav className="mt-10">
          <ul>
            <li>
              <button
                onClick={() => setActiveSection('dashboard')}
                className={`flex items-center p-4 text-lg text-gray-700 hover:bg-gray-100 rounded-md transition-all duration-200 ${
                  activeSection === 'dashboard' ? 'bg-gray-200 font-bold' : ''
                }`}
              >
                Dashboard
              </button>
            </li>
            <li>
              <button
                onClick={() => setActiveSection('cockfights')}
                className={`flex items-center p-4 text-lg text-gray-700 hover:bg-gray-100 rounded-md transition-all duration-200 ${
                  activeSection === 'cockfights' ? 'bg-gray-200 font-bold' : ''
                }`}
              >
                Cockfights
              </button>
            </li>
          </ul>
        </nav>
      </div>

      {/* Main Content */}
      <div className="flex-1 p-8 overflow-y-auto">
        <h1 className="text-4xl font-bold mb-6 text-gray-800 capitalize">
          {activeSection}
        </h1>
        {renderSection()}
      </div>
    </div>
  );
}

export default Dashboard;
