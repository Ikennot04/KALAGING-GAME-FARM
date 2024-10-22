'use client';
import React from 'react';
import { Bar } from 'react-chartjs-2';
import Image from 'next/image';
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  BarElement,
  Title,
  Tooltip,
  Legend,
} from 'chart.js';

// Register the required components
ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

// Sample data for monthly and yearly wins
const monthlyWins = [
  { month: 'January', wins: 10 },
  { month: 'February', wins: 8 },
  { month: 'March', wins: 12 },
  { month: 'April', wins: 15 },
  { month: 'May', wins: 7 },
  { month: 'June', wins: 9 },
  { month: 'July', wins: 5 },
  { month: 'August', wins: 8 },
  { month: 'September', wins: 6 },
  { month: 'October', wins: 5 },
  { month: 'November', wins: 0 },
  { month: 'December', wins: 0 },
];

const yearlyWins = [
  { year: 2017, wins: 90 },
  { year: 2018, wins: 120 },
  { year: 2019, wins: 43 },
  { year: 2020, wins: 36 },
  { year: 2021, wins: 68 },
  { year: 2022, wins: 86 },
  { year: 2023, wins: 58 },
  { year: 2024, wins: 67 },
];

// Sample data for chicken entries and deaths (monthly)
const monthlyEntries = [
  { month: 'January', entries: 50, deaths: 2 },
  { month: 'February', entries: 60, deaths: 3 },
  { month: 'March', entries: 70, deaths: 1 },
  { month: 'April', entries: 80, deaths: 4 },
  { month: 'May', entries: 90, deaths: 2 },
  { month: 'June', entries: 40, deaths: 1 },
  { month: 'July', entries: 50, deaths: 2 },
  { month: 'August', entries: 30, deaths: 0 },
  { month: 'September', entries: 60, deaths: 1 },
  { month: 'October', entries: 70, deaths: 2 },
  { month: 'November', entries: 80, deaths: 3 },
  { month: 'December', entries: 90, deaths: 0 },
];

// Sample data for chicken entries and deaths (yearly)
const yearlyEntries = [
  { year: 2017, entries: 500, deaths: 25 },
  { year: 2018, entries: 600, deaths: 30 },
  { year: 2019, entries: 700, deaths: 20 },
  { year: 2020, entries: 800, deaths: 35 },
  { year: 2021, entries: 900, deaths: 40 },
  { year: 2022, entries: 600, deaths: 15 },
  { year: 2023, entries: 800, deaths: 20 },
  { year: 2024, entries: 750, deaths: 25 },
];

function Statistics() {
  // Data for Monthly Wins Bar Chart
  const monthlyData = {
    labels: monthlyWins.map((item) => item.month),
    datasets: [
      {
        label: 'Wins per Month',
        data: monthlyWins.map((item) => item.wins),
        backgroundColor: 'rgba(75, 192, 192, 0.6)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1,
      },
    ],
  };

  // Data for Yearly Wins Bar Chart
  const yearlyData = {
    labels: yearlyWins.map((item) => item.year),
    datasets: [
      {
        label: 'Wins per Year',
        data: yearlyWins.map((item) => item.wins),
        backgroundColor: 'rgba(153, 102, 255, 0.6)',
        borderColor: 'rgba(153, 102, 255, 1)',
        borderWidth: 1,
      },
    ],
  };

  // Data for Chicken Entries and Deaths (Monthly)
  const entriesData = {
    labels: monthlyEntries.map((item) => item.month),
    datasets: [
      {
        label: 'Entries',
        data: monthlyEntries.map((item) => item.entries),
        backgroundColor: 'rgba(54, 162, 235, 0.6)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
      },
      {
        label: 'Deaths',
        data: monthlyEntries.map((item) => item.deaths),
        backgroundColor: 'rgba(255, 99, 132, 0.6)',
        borderColor: 'rgba(255, 99, 132, 1)',
        borderWidth: 1,
      },
    ],
  };

  // Data for Chicken Entries and Deaths (Yearly)
  const yearlyEntriesData = {
    labels: yearlyEntries.map((item) => item.year),
    datasets: [
      {
        label: 'Entries',
        data: yearlyEntries.map((item) => item.entries),
        backgroundColor: 'rgba(54, 162, 235, 0.6)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
      },
      {
        label: 'Deaths',
        data: yearlyEntries.map((item) => item.deaths),
        backgroundColor: 'rgba(255, 99, 132, 0.6)',
        borderColor: 'rgba(255, 99, 132, 1)',
        borderWidth: 1,
      },
    ],
  };

  return (
    <div className="min-h-screen bg-gradient-to-r from-blue-100 to-green-200 py-10 px-4">
      <Image 
            src="/MONEYKEN.gif" // Path to your GIF
            alt="Triangle Animation"
            width={200} // Set your desired width
            height={100} // Set your desired height
            className="rounded" // Optional: Add rounded corners to the GIF
          />
      <div className="max-w-6xl mx-auto bg-white rounded-lg shadow-lg p-8">
        
        <h1 className="text-4xl font-bold text-center mb-8 text-blue-600" >Statistics</h1>
        

        {/* Flexbox Container for Charts */}
        <div className="flex flex-col md:flex-row justify-between gap-6">
          {/* Monthly Wins Bar Chart */}
          <div className="flex-1" style={{ minWidth: '350px', maxWidth: '800px' }}>
            <h2 className="text-2xl font-semibold mb-4 text-blue-500">Monthly Wins</h2>
            <div className="bg-gray-50 rounded-lg p-4 shadow-md border border-gray-300">
              <Bar
                data={monthlyData}
                options={{
                  responsive: true,
                  maintainAspectRatio: false,
                  plugins: {
                    legend: {
                      position: 'top',
                      labels: {
                        color: '#4B5563', // Tailwind color for text
                      },
                    },
                    title: {
                      display: true,
                      text: 'Monthly Wins',
                      color: '#1F2937', // Tailwind color for text
                    },
                  },
                }}
                height={400}
              />
            </div>
          </div>

          {/* Yearly Wins Bar Chart */}
          <div className="flex-1" style={{ minWidth: '350px', maxWidth: '800px' }}>
            <h2 className="text-2xl font-semibold mb-4 text-blue-500">Yearly Wins</h2>
            <div className="bg-gray-50 rounded-lg p-4 shadow-md border border-gray-300">
              <Bar
                data={yearlyData}
                options={{
                  responsive: true,
                  maintainAspectRatio: false,
                  plugins: {
                    legend: {
                      position: 'top',
                      labels: {
                        color: '#4B5563',
                      },
                    },
                    title: {
                      display: true,
                      text: 'Yearly Wins',
                      color: '#1F2937',
                    },
                  },
                }}
                height={400}
              />
            </div>
          </div>
        </div>

        {/* Flexbox Container for Entries and Deaths Chart (Monthly) */}
        <div className="flex flex-col md:flex-row justify-between gap-6 mt-8">
          {/* Chicken Entries and Deaths Bar Chart (Monthly) */}
          <div className="flex-1" style={{ minWidth: '350px', maxWidth: '800px' }}>
            <h2 className="text-2xl font-semibold mb-4 text-blue-500">Monthly Entries and Deaths</h2>
            <div className="bg-gray-50 rounded-lg p-4 shadow-md border border-gray-300">
              <Bar
                data={entriesData}
                options={{
                  responsive: true,
                  maintainAspectRatio: false,
                  plugins: {
                    legend: {
                      position: 'top',
                      labels: {
                        color: '#4B5563',
                      },
                    },
                    title: {
                      display: true,
                      text: 'Monthly Chicken Entries and Deaths',
                      color: '#1F2937',
                    },
                  },
                }}
                height={400}
              />
            </div>
          </div>

          {/* Chicken Entries and Deaths Bar Chart (Yearly) */}
          <div className="flex-1" style={{ minWidth: '350px', maxWidth: '800px' }}>
            <h2 className="text-2xl font-semibold mb-4 text-blue-500">Yearly Entries and Deaths</h2>
            <div className="bg-gray-50 rounded-lg p-4 shadow-md border border-gray-300">
              <Bar
                data={yearlyEntriesData}
                options={{
                  responsive: true,
                  maintainAspectRatio: false,
                  plugins: {
                    legend: {
                      position: 'top',
                      labels: {
                        color: '#4B5563',
                      },
                    },
                    title: {
                      display: true,
                      text: 'Yearly Chicken Entries and Deaths',
                      color: '#1F2937',
                    },
                  },
                }}
                height={400}
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default Statistics;
