'use client'
'use client';
import React, { useState, useEffect } from 'react';
import Image from 'next/image';

const images = [
    { src: '/KALAGINGGF.jpg', description: 'First Image', id: '1' },
    { src: '/MANGKOS.jpg', description: 'Second Image', id: '2' },
    { src: '/MANOK.jpg', description: 'Third Image', id: '3' },
];

const workers = [
    { src: '/worker1.jpg', name: 'ENGR. JUNARD A. CAÑETE', role: 'KALAGING GAMEFARM OWNER' },
    { src: '/root.jpg', name: 'ATTY. FAUSTO F. FLORES', role: 'HANDLER/BREEDER - CO-OWNER' },
    { src: '/branch.jpg', name: 'KIERY A. FLORES, JD', role: 'HANDLER/BREEDER' },
    { src: '/branch3(2).jpg', name: 'KENT JOHN BRIAN C. FLORES', role: 'TIGPANGAYO UG BAHIN SA DAUG' },
    { src: '/branch2.jpg', name: 'JOHN CARLO C. ROLLON', role: 'TIGPANGAYO GIHAPON UG BAHIN SA DAUG' },
    // Add more workers as needed
];

function AboutUs() {
    const [currentImage, setCurrentImage] = useState(0);
    const [currentWorker, setCurrentWorker] = useState(0);

    // Automatically switch the background image every 5 seconds
    useEffect(() => {
        const interval = setInterval(() => {
            setCurrentImage((prevImage) => (prevImage + 1) % images.length);
        }, 5000); // 5 seconds
        return () => clearInterval(interval);
    }, []);

    const handleNextWorker = () => {
        setCurrentWorker((prevWorker) => (prevWorker + 1) % workers.length);
    };

    const handleBackWorker = () => {
        setCurrentWorker((prevWorker) => (prevWorker - 1 + workers.length) % workers.length);
    };

    return (
        <div className="relative min-h-screen bg-cover bg-center" style={{ backgroundImage: `url(${images[currentImage].src})`, transition: 'background-image 1s ease-in-out' }}>
            {/* Gradient Overlay */}
            <div className="absolute inset-0 bg-gradient-to-b from-black/60 to-black/30"></div>

            {/* Main Content */}
            <div className="relative z-10 flex flex-col items-center justify-center py-10 px-4">
                {/* First Section: About Us */}
                <div className="max-w-5xl w-full bg-white/80 p-10 rounded-lg shadow-lg mb-10">
                    <h1 className="text-5xl font-extrabold mb-8 text-blue-700 text-center">About Us</h1>
                    <p className="text-xl mb-8 text-gray-800 text-center">
                        Welcome to <span className="font-bold text-blue-700">KALAGING GAMEFARM</span>! We are passionate about breeding and nurturing high-quality cockfighting birds.
                    </p>
                    <h2 className="text-3xl font-semibold mb-6 text-blue-600 text-center">Our Mission</h2>
                    <p className="text-lg mb-6 text-gray-700 text-center">
                        Our mission is to create a sustainable and ethical breeding environment, promoting responsible practices while supporting a community of breeders.
                    </p>
                </div>
                    {/* Workers Section */}
                    <div className="max-w-5xl w-full bg-white/80 p-10 rounded-lg shadow-lg text-center">
                        <h2 className="text-4xl font-bold mb-8 text-blue-700">Meet Our Team</h2>

                        {/* Worker Details Display */}
                        <div className="flex flex-col items-center mb-8">
                            <Image
                                src={workers[currentWorker].src}
                                alt={workers[currentWorker].name}
                                width={250} // Increased width
                                height={250} // Increased height
                                className="rounded-full mb-4 shadow-lg transition-transform duration-200 hover:scale-110" // Added shadow and hover effect
                            />
                            <h3 className="text-3xl font-bold text-blue-600 mb-2">{workers[currentWorker].name}</h3> {/* Increased text size */}
                            <p className="text-lg text-gray-700">{workers[currentWorker].role}</p> {/* Increased text size */}
                        </div>
                        
                        {/* Navigation Buttons */}
                        <div className="flex justify-between w-full max-w-xs mx-auto">
                            <button
                                className="bg-blue-500 text-white px-4 py-2 rounded-lg"
                                onClick={handleBackWorker}
                            >
                                Back
                            </button>
                            <button
                                className="bg-blue-500 text-white px-4 py-2 rounded-lg"
                                onClick={handleNextWorker}
                            >
                                Next
                            </button>
                        </div>
                    </div>

            </div>
        </div>
    );
}

export default AboutUs;
