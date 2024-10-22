import React from 'react'


function Schedule() {

  return (
    <div>
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
  )
}

export default Schedule
