'use client';
import React, { useState } from 'react';
import Schedule from './schedule/page';
import FightingNow from './fightingnow/page';
import PastFight from './pastfight/page';

function CockFights() {
  // Separate states for each modal
  const [isScheduleOpen, setIsScheduleOpen] = useState(false);
  const [isFightingNowOpen, setIsFightingNowOpen] = useState(false);
  const [isPastFightOpen, setIsPastFightOpen] = useState(false);

  // Reusable Modal Component
  const Modal = ({ isOpen, onClose, children }) => {
    if (!isOpen) return null;

    return (
      <div className="fixed inset-0 bg-black bg-opacity-70 flex justify-center items-center z-50">
        <div className="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
          {children}
          <div className="flex justify-between mt-4">
            <button
              className="bg-red-500 text-white px-4 py-2 rounded-md"
              onClick={onClose}
            >
              Close
            </button>
            <button
              className="bg-blue-500 text-white px-4 py-2 rounded-md"
              onClick={onClose}
            >
              OK
            </button>
          </div>
        </div>
      </div>
    );
  };

  return (
    <div className="min-h-screen bg-gray-100 p-8">
      {/* Schedule Section */}
      <div className="mb-8">
        <button
          className="bg-blue-600 text-white px-4 py-2 rounded-md"
          onClick={() => setIsScheduleOpen(true)}
        >
          <div className="bg-white p-6 rounded-lg shadow-lg">
            <h1 className="text-4xl font-bold text-blue-800 mb-4">Schedule sa Away</h1>
            <p className="text-lg text-gray-600">
              Check out the upcoming cockfight schedules below. Stay updated to never miss a match!
            </p>
            <div className="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
              {/* Example fight schedule */}
              <div className="bg-blue-50 p-4 rounded-lg shadow-md">
                <h3 className="text-xl font-bold text-blue-700 mb-2">October 25, 2024</h3>
                <p className="text-gray-700">Location: Kalaging Gamefarm Arena</p>
                <p className="text-gray-600">Time: 3:00 PM</p>
              </div>
              <div className="bg-blue-50 p-4 rounded-lg shadow-md">
                <h3 className="text-xl font-bold text-blue-700 mb-2">November 1, 2024</h3>
                <p className="text-gray-700">Location: Mangkon Stadium</p>
                <p className="text-gray-600">Time: 5:00 PM</p>
              </div>
            </div>
          </div>
        </button>

        <Modal isOpen={isScheduleOpen} onClose={() => setIsScheduleOpen(false)}>
          <Schedule />
        </Modal>
      </div>

      {/* Fighting Now Section */}
      <div className="mb-8">
        <button
          className="bg-blue-600 text-white px-4 py-2 rounded-md"
          onClick={() => setIsFightingNowOpen(true)}
        >
          <div className="bg-white p-6 rounded-lg shadow-lg">
            <h2 className="text-3xl font-bold text-green-700 mb-4">Naay Away Ron?</h2>
            <p className="text-lg text-gray-600">
              Find out if there's a cockfight happening right now.
            </p>
            <div className="mt-6">
              <p className="text-2xl font-semibold text-gray-800">Yes, the fight is on!</p>
              <p className="text-gray-600">Location: Kalaging Gamefarm Arena</p>
            </div>
          </div>
        </button>

        <Modal isOpen={isFightingNowOpen} onClose={() => setIsFightingNowOpen(false)}>
          <FightingNow />
        </Modal>
      </div>

      {/* Past Fights Section */}
      <div>
        <button
          className="bg-blue-600 text-white px-4 py-2 rounded-md"
          onClick={() => setIsPastFightOpen(true)}
        >
          <div className="bg-white p-6 rounded-lg shadow-lg">
            <h3 className="text-2xl font-bold text-red-700 mb-4">Past nga Away</h3>
            <p className="text-lg text-gray-600">
              Recap of the last matches and their outcomes.
            </p>
            <div className="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
              <div className="bg-gray-50 p-4 rounded-lg shadow-md">
                <h4 className="text-xl font-bold text-red-700 mb-2">October 18, 2024</h4>
                <p className="text-gray-700">Winner: Red Bull</p>
                <p className="text-gray-600">Opponent: Black Hawk</p>
              </div>
              <div className="bg-gray-50 p-4 rounded-lg shadow-md">
                <h4 className="text-xl font-bold text-red-700 mb-2">October 12, 2024</h4>
                <p className="text-gray-700">Winner: White Lightning</p>
                <p className="text-gray-600">Opponent: Golden Phoenix</p>
              </div>
            </div>
          </div>
        </button>

        <Modal isOpen={isPastFightOpen} onClose={() => setIsPastFightOpen(false)}>
          <PastFight />
        </Modal>
      </div>
    </div>
  );
}

export default CockFights;
