import React from 'react';
import Image from 'next/image';
import Link from 'next/link';

function BirdList() {
  const images = [
    { src: '/KALAGINGGF.jpg', description: 'KANI', id: '1', owner: 'Kentoy', timestamp: '2024-10-18' },
    { src: '/MANGKOS.jpg', description: 'KANA', id: '2', owner: 'Kentoy', timestamp: '2024-10-18' },
    { src: '/MANKOS.jpg', description: 'KANI PAJUD', id: '3', owner: 'Kentoy', timestamp: '2024-10-18' },
    { src: '/MANOK.jpg', description: 'KANA NAPUD', id: '4', owner: 'Kentoy', timestamp: '2024-10-18' },
    { src: '/branch.jpg', description: 'TUARA', id: '5', owner: 'Kentoy', timestamp: '2024-10-18' },
    { src: '/root.jpg', description: 'DIARA', id: '6', owner: 'Kentoy', timestamp: '2024-10-18' },
    { src: '/root2.jpg', description: 'DIARA PUD', id: '7', owner: 'Kentoy', timestamp: '2024-10-18' },
    { src: '/branch2.jpg', description: 'AHH GRABEH', id: '8', owner: 'Kentoy', timestamp: '2024-10-18' },
    { src: '/branch3_2.jpg', description: 'SA NAMAN', id: '9', owner: 'Kentoy', timestamp: '2024-10-18' },
  ];

  return (
    <div>
      <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        {images.map((bird) => (
          <Link href={`/birds/${bird.id}`} key={bird.id}>
            <div className='text-center bg-white p-4 rounded-lg shadow-md transition-transform duration-200 hover:scale-105 hover:shadow-lg'>
              <Image 
                src={bird.src} 
                alt={bird.description} 
                width={200} 
                height={150} 
                className='rounded-lg w-full h-auto'
              />
              <p className='mt-4 text-gray-600'>{bird.description}</p>
            </div>
          </Link>
        ))}
      </div>
    </div>
  );
}

export default BirdList;
