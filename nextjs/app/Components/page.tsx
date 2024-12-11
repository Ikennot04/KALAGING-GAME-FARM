import React from 'react';
import { Worker } from '@/app/hooks/Gethooks'; // Make sure to import the Worker type

interface WorkerCarouselProps {
    workers: Worker[];
    currentWorker: number;
    onNextWorker: () => void;
    onBackWorker: () => void;
    onWorkerClick: (workerId: number) => void;
}

export function WorkerCarousel({ 
    workers, 
    currentWorker, 
    onNextWorker, 
    onBackWorker, 
    onWorkerClick 
}: WorkerCarouselProps) {
    return (
        <div className="flex items-center justify-center space-x-4">
            {workers.length > 1 && (
                <button
                    onClick={onBackWorker}
                    className="text-4xl text-blue-600 hover:text-blue-800 transition-colors duration-200"
                >
                    &lt;
                </button>
            )}

            {workers.length > 0 && (
                <>
                    {workers.length > 1 && (
                        <div className="opacity-70 transition-opacity duration-300 hover:opacity-100">
                            <img
                                src={`${process.env.NEXT_PUBLIC_API_URL}/storage/images/${workers[(currentWorker - 1 + workers.length) % workers.length].image}`}
                                alt={workers[(currentWorker - 1 + workers.length) % workers.length].name}
                                className="rounded-full shadow-lg w-[150px] h-[150px] object-cover"
                                onError={(e) => {
                                    const target = e.target as HTMLImageElement;
                                    target.src = '/default-avatar.png';
                                    console.log('Image failed to load:', workers[(currentWorker - 1 + workers.length) % workers.length].image);
                                }}
                            />
                            <h3 className="text-sm mt-2 text-center">
                                {workers[(currentWorker - 1 + workers.length) % workers.length].name}
                            </h3>
                        </div>
                    )}

                    {/* Current Worker - always show */}
                    <div 
                        className="transform scale-110 transition-transform duration-300 cursor-pointer"
                        onClick={() => onWorkerClick(parseInt(workers[currentWorker].id))}
                    >
                        <img
                            src={`${process.env.NEXT_PUBLIC_API_URL}/storage/images/${workers[currentWorker].image}`}
                            alt={workers[currentWorker].name}
                            className="rounded-full shadow-lg w-[200px] h-[200px] object-cover"
                            onError={(e) => {
                                const target = e.target as HTMLImageElement;
                                target.src = '/default-avatar.png';
                                console.log('Image failed to load:', workers[currentWorker].image);
                            }}
                        />
                        <h3 className="text-xl font-bold mt-4 text-center text-blue-600">
                            {workers[currentWorker].name}
                        </h3>
                        <p className="text-gray-600 text-center">{workers[currentWorker].position}</p>
                    </div>

                    {workers.length > 1 && (
                        <div className="opacity-70 transition-opacity duration-300 hover:opacity-100">
                            <img
                                src={`${process.env.NEXT_PUBLIC_API_URL}/storage/images/${workers[(currentWorker + 1) % workers.length].image}`}
                                alt={workers[(currentWorker + 1) % workers.length].name}
                                className="rounded-full shadow-lg w-[150px] h-[150px] object-cover"
                                onError={(e) => {
                                    const target = e.target as HTMLImageElement;
                                    target.src = '/default-avatar.png';
                                    console.log('Image failed to load:', workers[(currentWorker + 1) % workers.length].image);
                                }}
                            />
                            <h3 className="text-sm mt-2 text-center">
                                {workers[(currentWorker + 1) % workers.length].name}
                            </h3>
                        </div>
                    )}
                </>
            )}

            {workers.length > 1 && (
                <button
                    onClick={onNextWorker}
                    className="text-4xl text-blue-600 hover:text-blue-800 transition-colors duration-200"
                >
                    &gt;
                </button>
            )}
        </div>
    );
}