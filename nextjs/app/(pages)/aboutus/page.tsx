'use client';
import React, { useState, useEffect } from 'react';
import { useWorkers } from '@/app/hooks/Gethooks';
import { useRouter } from 'next/navigation';
import { WorkerCarousel } from '@/app/Components/page';

function AboutUs() {
    const [currentWorker, setCurrentWorker] = useState(0);
    const [currentImage, setCurrentImage] = useState(0);
    const { workers, loading, error } = useWorkers();
    const router = useRouter();

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

    const handleWorkerClick = (workerId: number) => {
        router.push(`/workers/${workerId}`);
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
                <div className="text-gray-500 text-xl">No team members to display</div>
            </div>
        );
    }

    return (
        <div className="relative min-h-screen bg-cover bg-center transition-all duration-1000"
            style={{ 
                backgroundImage: workers[currentImage]?.image 
                    ? `url(http://127.0.0.1:8000/storage/images/${workers[currentImage].image})`
                    : 'none',
                backgroundSize: 'cover',
                backgroundPosition: 'center'
            }}>
            <div className="absolute inset-0 bg-gradient-to-b from-black/70 to-black/40"></div>

            <div className="relative z-10 flex flex-col items-center justify-center py-10 px-4">
                <div className="max-w-4xl w-full bg-white/90 p-8 rounded-lg shadow-lg mb-10">
                    <div className="flex items-center justify-center mb-6">
                        <img 
                            src="/SEKIN.gif" 
                            alt="Logo Animation"
                            className="rounded mr-4 w-[200px] h-[250px]" 
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
                    <h2 className="text-4xl font-bold mb-6 text-blue-800 text-center">Meet Our Handlers</h2>
                    
                    <WorkerCarousel 
                        workers={workers}
                        currentWorker={currentWorker}
                        onNextWorker={handleNextWorker}
                        onBackWorker={handleBackWorker}
                        onWorkerClick={handleWorkerClick}
                    />
                </div>
            </div>
        </div>
    );
}

export default AboutUs;