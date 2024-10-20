import React from 'react';
import Image from 'next/image';
import Link from 'next/link';

function BirdList() {
  const images = [
    { src: '/KALAGINGGF.jpg', description: 'KANI', id: '1', owner: 'Kentoy', timestamp: '2024-10-18' },
    { src: '/MANGKOS.jpg', description: 'KANI', id: '2', owner: 'Kentoy', timestamp: '2024-10-18' },
    { src: '/MANKOS.jpg', description: 'KANI', id: '3', owner: 'Kentoy', timestamp: '2024-10-18' },
    { src: '/MANOK.jpg', description: 'KANI', id: '4', owner: 'Kentoy', timestamp: '2024-10-18' },
  ];

  return (
    <div>
      <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        {images.map((bird) => (
          <Link href={`/birds/${bird.id}`} key={bird.id}>
            <div className='text-center bg-white p-4 rounded-lg shadow-md transition-transform duration-200 hover:scale-105 hover:shadow-lg'>
              <Image 
                src={bird.src} 
                alt={bird.description} 
                width={200} 
                height={100} 
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
