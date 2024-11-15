'use client';
import React, { useState, useEffect } from 'react';
import Image from 'next/image';

const images = [
    { src: '/KALAGINGGF.jpg', description: 'First Image', id: '1' },
    { src: '/MANGKOS.jpg', description: 'Second Image', id: '2' },
    { src: '/MANOK.jpg', description: 'Third Image', id: '3' },
];

const workers = [
    { src: '/root2.jpg', name: 'ENGR. JUNARD A. CAÑETE', role: 'KALAGING GAMEFARM OWNER' },
    { src: '/root.jpg', name: 'ATTY. FAUSTO F. FLORES', role: 'HANDLER/BREEDER - CO-OWNER' },
    { src: '/branch.jpg', name: 'KIERY A. FLORES, J.D.', role: 'HANDLER/BREEDER' },
    { src: '/branch3_2.jpg', name: 'KENT JOHN BRIAN C. FLORES', role: 'TIGPANGAYO UG BAHIN SA DAUG' },
    { src: '/branch2.jpg', name: 'JOHN CARLO C. ROLLON', role: 'TIGPANGAYO GIHAPON UG BAHIN SA DAUG' },
    { src: '/tito.jpg', name: 'DR. CESAR ROLLON', role: 'TIG TAYHOP SA SAMAD' },
];

function AboutUs() {
    const [currentWorker, setCurrentWorker] = useState(0);
    const [currentImage, setCurrentImage] = useState(0);

    const handleNextWorker = () => {
        setCurrentWorker((prevWorker) => (prevWorker + 1) % workers.length);
    };

    const handleBackWorker = () => {
        setCurrentWorker((prevWorker) => (prevWorker - 1 + workers.length) % workers.length);
    };

    // Automatically switch the background image every 5 seconds
    useEffect(() => {
        const interval = setInterval(() => {
            setCurrentImage((prevImage) => (prevImage + 1) % images.length);
        }, 5000); // Change every 5 seconds
        return () => clearInterval(interval);
    }, []);

    return (
        <div
            className="relative min-h-screen bg-cover bg-center"
            style={{ backgroundImage: `url(${images[currentImage].src})`, transition: 'background-image 1s ease-in-out' }}
        >
            
            <div className="absolute inset-0 bg-gradient-to-b from-black/70 to-black/40"></div>

            
            <div className="relative z-10 flex flex-col items-center justify-center py-10 px-4">
                
                
                <div className="max-w-4xl w-full bg-white/90 p-8 rounded-lg shadow-lg mb-10 transition-transform duration-500 hover:scale-105">
                    <div className="flex items-center justify-center mb-6">
                        <Image 
                            src="/SEKIN.gif" 
                            alt="Triangle Animation"
                            width={200}
                            height={250}
                            className="rounded mr-4" 
                        />
                    </div>
                    <p className="text-lg mb-6 text-gray-800 text-center">
                        Welcome to <span className="font-bold text-blue-600">KALAGING GAMEFARM</span>! We are passionate about breeding and nurturing high-quality cockfighting birds.
                    </p>
                    <h2 className="text-3xl font-semibold mb-4 text-blue-600 text-center">Our Mission</h2>
                    <p className="text-md mb-4 text-gray-700 text-center">
                        Our mission is to create a sustainable and ethical breeding environment, promoting responsible practices while supporting a community of breeders.
                    </p>
                </div>

                
                <div className="max-w-4xl w-full bg-white/90 p-8 rounded-lg shadow-lg text-center transition-transform duration-500 hover:scale-105">
                    <h2 className="text-4xl font-bold mb-6 text-blue-800">Meet Our Team</h2>

                    
                    <div className="flex items-center justify-center space-x-4 mb-6">
                        
                        <button
                            className="text-4xl text-blue-600 hover:text-blue-800 transition-colors duration-200 focus:outline-none transform hover:scale-110"
                            onClick={handleBackWorker}
                        >
                            &lt;
                        </button>

                        {/* Previous Worker */}
                        <div className="opacity-70 transition-opacity duration-300 hover:opacity-100">
                            <Image
                                src={workers[(currentWorker - 1 + workers.length) % workers.length].src}
                                alt={workers[(currentWorker - 1 + workers.length) % workers.length].name}
                                width={150}
                                height={150}
                                className="rounded-full shadow-lg w-auto h-auto transform hover:scale-105 transition-transform duration-200"
                            />
                            <h3 className="text-md font-semibold text-gray-600">{workers[(currentWorker - 1 + workers.length) % workers.length].name}</h3>
                        </div>

                        {/* Current Worker */}
                        <div className="transform scale-110 transition-transform duration-300">
                            <Image
                                src={workers[currentWorker].src}
                                alt={workers[currentWorker].name}
                                width={250}
                                height={250}
                                className="rounded-full shadow-lg w-auto h-auto"
                            />
                            <h3 className="text-2xl font-bold text-blue-600 mt-4">{workers[currentWorker].name}</h3>
                            <p className="text-md text-gray-700">{workers[currentWorker].role}</p>
                        </div>

                        {/* Next Worker */}
                        <div className="opacity-70 transition-opacity duration-300 hover:opacity-100">
                            <Image
                                src={workers[(currentWorker + 1) % workers.length].src}
                                alt={workers[(currentWorker + 1) % workers.length].name}
                                width={150}
                                height={150}
                                className="rounded-full shadow-lg w-auto h-auto transform hover:scale-105 transition-transform duration-200"
                            />
                            <h3 className="text-md font-semibold text-gray-600">{workers[(currentWorker + 1) % workers.length].name}</h3>
                        </div>

                        {/* Next Button */}
                        <button
                            className="text-4xl text-blue-600 hover:text-blue-800 transition-colors duration-200 focus:outline-none transform hover:scale-110"
                            onClick={handleNextWorker}
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
