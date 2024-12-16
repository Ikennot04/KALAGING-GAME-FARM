'use client';
import React, { useState, ReactNode } from 'react';
import Schedule from './schedule/page';
import FightingNow from './fightingnow/page';
import PastFight from './pastfight/page';

interface ModalProps {
  isOpen: boolean;
  onClose: () => void;
  children: ReactNode;
}

const Modal = ({ isOpen, onClose, children }: ModalProps) => {
  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 bg-black bg-opacity-70 flex justify-center items-center z-50">
      <div className="bg-white p-6 rounded-lg shadow-2xl max-w-lg w-full">
        {children}
        <div className="flex justify-end mt-6">
          <button
            className="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg transition-all duration-300 mr-2"
            onClick={onClose}
          >
            Close
          </button>
          <button
            className="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg transition-all duration-300"
            onClick={onClose}
          >
            OK
          </button>
        </div>
      </div>
    </div>
  );
};

function CockFights() {
  const [isScheduleOpen, setIsScheduleOpen] = useState(false);
  const [isFightingNowOpen, setIsFightingNowOpen] = useState(false);
  const [isPastFightOpen, setIsPastFightOpen] = useState(false);

  return (
    <div className="min-h-screen bg-gradient-to-b from-gray-100 to-gray-300 p-8">
      <h1 className="text-center text-5xl font-extrabold text-gray-800 mb-10">
        SCHEDULES
      </h1>
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        {/* Schedule Section */}
        <button
          className="transition-transform transform hover:scale-105"
          onClick={() => setIsScheduleOpen(true)}
        >
          <div className="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
            <h2 className="text-3xl font-bold text-blue-800 mb-4">Upcoming Away</h2>
            <p className="text-lg text-gray-600 mb-6">
              Check out the upcoming cockfight schedules below. Stay updated to never miss a match!
            </p>
            <div className="grid grid-cols-1 gap-4">
              <div className="bg-blue-50 p-4 rounded-lg shadow-md hover:bg-blue-100 transition-colors">
                <h3 className="text-xl font-semibold text-blue-700 mb-2">October 25, 2024</h3>
                <p className="text-gray-700">Location: Kalaging Gamefarm Arena</p>
                <p className="text-gray-600">Time: 3:00 PM</p>
              </div>
              <div className="bg-blue-50 p-4 rounded-lg shadow-md hover:bg-blue-100 transition-colors">
                <h3 className="text-xl font-semibold text-blue-700 mb-2">November 1, 2024</h3>
                <p className="text-gray-700">Location: Mangkon Stadium</p>
                <p className="text-gray-600">Time: 5:00 PM</p>
              </div>
            </div>
          </div>
        </button>
        <Modal isOpen={isScheduleOpen} onClose={() => setIsScheduleOpen(false)}>
          <Schedule />
        </Modal>

        {/* Fighting Now Section */}
        <button
          className="transition-transform transform hover:scale-105"
          onClick={() => setIsFightingNowOpen(true)}
        >
          <div className="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
            <h2 className="text-3xl font-bold text-green-700 mb-4">Naay Away Ron?</h2>
            <p className="text-lg text-gray-600 mb-6">
              Find out if there's a cockfight happening right now.
            </p>
            <div className="bg-green-50 p-4 rounded-lg shadow-md hover:bg-green-100 transition-colors">
              <p className="text-2xl font-semibold text-gray-800">Yes, the fight is on!</p>
              <p className="text-gray-600">Location: Kalaging Gamefarm Arena</p>
            </div>
          </div>
        </button>
        <Modal isOpen={isFightingNowOpen} onClose={() => setIsFightingNowOpen(false)}>
          <FightingNow />
        </Modal>

        {/* Past Fights Section */}
        <button
          className="transition-transform transform hover:scale-105"
          onClick={() => setIsPastFightOpen(true)}
        >
          <div className="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
            <h2 className="text-3xl font-bold text-red-700 mb-4">Past nga Away</h2>
            <p className="text-lg text-gray-600 mb-6">
              Recap of the last matches and their outcomes.
            </p>
            <div className="grid grid-cols-1 gap-4">
              <div className="bg-gray-50 p-4 rounded-lg shadow-md hover:bg-gray-100 transition-colors">
                <h3 className="text-xl font-semibold text-red-700 mb-2">October 18, 2024</h3>
                <p className="text-gray-700">Winner: Red Bull</p>
                <p className="text-gray-600">Opponent: Black Hawk</p>
              </div>
              <div className="bg-gray-50 p-4 rounded-lg shadow-md hover:bg-gray-100 transition-colors">
                <h3 className="text-xl font-semibold text-red-700 mb-2">October 12, 2024</h3>
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
