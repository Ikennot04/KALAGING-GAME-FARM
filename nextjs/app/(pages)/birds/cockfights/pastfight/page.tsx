import React from 'react'

function PastFight() {
  return (
    <div>
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
  )
}

export default PastFight
