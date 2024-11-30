'use client';
import React, { useState, useEffect } from 'react';
import Image from 'next/image';

interface Worker {
    id: string;
    name: string;
    position: string;
    image: string;
    created_at: string;
    updated_at: string;
}

interface CarouselImage {
    id: string;
    src: string;
    description: string;
}

function AboutUs() {
    const [currentWorker, setCurrentWorker] = useState(0);
    const [currentImage, setCurrentImage] = useState(0);
    const [workers, setWorkers] = useState<Worker[]>([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);

    // Fetch workers from API
    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await fetch('http://127.0.0.1:8000/api/workers', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch workers');
                }

                const data = await response.json();
                // Filter out deleted workers if needed
                const activeWorkers = data.filter((worker: Worker) => !worker.deleted);
                setWorkers(activeWorkers);
                setLoading(false);
            } catch (error) {
                console.error('Error fetching data:', error);
                setError('Failed to load content');
                setLoading(false);
            }
        };

        fetchData();
    }, []);

    // Auto-rotate background images
    useEffect(() => {
        if (workers.length === 0) return;

        const interval = setInterval(() => {
            setCurrentImage((prev) => (prev + 1) % workers.length);
        }, 5000);

        return () => clearInterval(interval);
    }, [workers.length]);

    const handleNextWorker = () => {
        if (workers.length) {
            setCurrentWorker((prev) => (prev + 1) % workers.length);
        }
    };

    const handleBackWorker = () => {
        if (workers.length) {
            setCurrentWorker((prev) => (prev - 1 + workers.length) % workers.length);
        }
    };

    if (loading) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <div className="animate-spin rounded-full h-32 w-32 border-t-2 border-b-2 border-blue-500"></div>
            </div>
        );
    }

    if (error) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <div className="text-red-500 text-xl">{error}</div>
            </div>
        );
    }

    if (workers.length === 0) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <div className="text-gray-500 text-xl">No team members found</div>
            </div>
        );
    }

    return (
        <div className="relative min-h-screen bg-cover bg-center transition-all duration-1000"
            style={{ 
                backgroundImage: `url(http://127.0.0.1:8000/storage/images/${workers[currentImage]?.image})`,
                backgroundSize: 'cover',
                backgroundPosition: 'center'
            }}>
            <div className="absolute inset-0 bg-gradient-to-b from-black/70 to-black/40"></div>

            <div className="relative z-10 flex flex-col items-center justify-center py-10 px-4">
                <div className="max-w-4xl w-full bg-white/90 p-8 rounded-lg shadow-lg mb-10">
                    <div className="flex items-center justify-center mb-6">
                        <Image 
                            src="/SEKIN.gif" 
                            alt="Logo Animation"
                            width={200}
                            height={250}
                            className="rounded mr-4" 
                        />
                    </div>
                    <p className="text-lg mb-6 text-gray-800 text-center">
                        Welcome to <span className="font-bold text-blue-600">KALAGING GAMEFARM</span>! 
                        We are passionate about breeding and nurturing high-quality cockfighting birds.
                    </p>
                    <h2 className="text-3xl font-semibold mb-4 text-blue-600 text-center">Our Mission</h2>
                    <p className="text-md mb-4 text-gray-700 text-center">
                        Our mission is to create a sustainable and ethical breeding environment, 
                        promoting responsible practices while supporting a community of breeders.
                    </p>
                </div>

                <div className="max-w-4xl w-full bg-white/90 p-8 rounded-lg shadow-lg">
                    <h2 className="text-4xl font-bold mb-6 text-blue-800 text-center">Meet Our Team</h2>
                    
                    <div className="flex items-center justify-center space-x-4">
                        <button
                            onClick={handleBackWorker}
                            className="text-4xl text-blue-600 hover:text-blue-800 transition-colors duration-200"
                        >
                            &lt;
                        </button>

                        {workers.length >= 3 && (
                            <>
                                {/* Previous Worker */}
                                <div className="opacity-70 transition-opacity duration-300 hover:opacity-100">
                                    <Image
                                        src={`http://127.0.0.1:8000/storage/images/${workers[(currentWorker - 1 + workers.length) % workers.length].image}`}
                                        alt={workers[(currentWorker - 1 + workers.length) % workers.length].name}
                                        width={150}
                                        height={150}
                                        className="rounded-full shadow-lg"
                                    />
                                    <h3 className="text-sm mt-2 text-center">
                                        {workers[(currentWorker - 1 + workers.length) % workers.length].name}
                                    </h3>
                                </div>

                                {/* Current Worker */}
                                <div className="transform scale-110 transition-transform duration-300">
                                    <Image
                                        src={`http://127.0.0.1:8000/storage/images/${workers[currentWorker].image}`}
                                        alt={workers[currentWorker].name}
                                        width={200}
                                        height={200}
                                        className="rounded-full shadow-lg"
                                    />
                                    <h3 className="text-xl font-bold mt-4 text-center text-blue-600">
                                        {workers[currentWorker].name}
                                    </h3>
                                    <p className="text-gray-600 text-center">{workers[currentWorker].position}</p>
                                </div>

                                {/* Next Worker */}
                                <div className="opacity-70 transition-opacity duration-300 hover:opacity-100">
                                    <Image
                                        src={`http://127.0.0.1:8000/storage/images/${workers[(currentWorker + 1) % workers.length].image}`}
                                        alt={workers[(currentWorker + 1) % workers.length].name}
                                        width={150}
                                        height={150}
                                        className="rounded-full shadow-lg"
                                    />
                                    <h3 className="text-sm mt-2 text-center">
                                        {workers[(currentWorker + 1) % workers.length].name}
                                    </h3>
                                </div>
                            </>
                        )}

                        <button
                            onClick={handleNextWorker}
                            className="text-4xl text-blue-600 hover:text-blue-800 transition-colors duration-200"
                        >
                            &gt;
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default AboutUs;