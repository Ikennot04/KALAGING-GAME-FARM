'use client';
import { useState, useEffect } from 'react';
import { useRouter } from 'next/navigation';

interface Bird {
    id: number;
    owner: string;
    image: string;
    handler: string;
    breed: string;
    created_at: string;
    weight: string;
    fighting_history: {
        wins: number;
        losses: number;
        draws: number;
    };
    fitness_level: string;
    diet: string;
}

export default function BirdDetails({
    params,
}: {
    params: { birdId: string };
}) {
    const router = useRouter();
    const [bird, setBird] = useState<Bird | null>(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        const fetchBirdDetails = async () => {
            try {
                const response = await fetch(`http://localhost:8000/api/birds/${params.birdId}`);
                if (!response.ok) {
                    throw new Error('Bird not found');
                }
                const data = await response.json();
                setBird(data);
            } catch (err) {
                setError(err instanceof Error ? err.message : 'Failed to load bird details');
            } finally {
                setLoading(false);
            }
        };

        fetchBirdDetails();
    }, [params.birdId]);

    const getFightingHistory = (bird: Bird) => {
        return bird.fighting_history || {
            wins: 0,
            losses: 0,
            draws: 0
        };
    };

    if (loading) {
        return <div className="p-8 text-center text-gray-700 text-xl font-semibold">Loading bird details...</div>;
    }

    if (error || !bird) {
        return <div className="p-8 text-center text-red-500 text-xl font-semibold">Error: {error || 'Bird not found'}</div>;
    }

    return (
        <div className="p-8 bg-gradient-to-tr from-blue-600 to-purple-600 min-h-screen flex flex-col items-center justify-center">
            <div className="max-w-5xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden relative">
                {/* Decorative Circle */}
                <div className="absolute top-0 right-0 bg-blue-200 w-40 h-40 rounded-full -translate-y-1/2 translate-x-1/2 shadow-lg animate-pulse"></div>

                <div className="p-6 md:p-10">
                    {/* Back Button */}
                    <button
                        onClick={() => router.back()}
                        className="mb-6 text-blue-500 hover:text-blue-700 font-medium flex items-center space-x-2 transition transform hover:scale-105"
                    >
                        <span className="material-icons">arrow_back</span>
                        <span>Back to List</span>
                    </button>

                    {/* Title */}
                    <h1 className="text-4xl font-bold text-center text-gray-800 mb-6 drop-shadow-lg">
                        Cockfighting Chicken Details
                    </h1>

                    {/* Bird Details Section */}
                    <div className="flex flex-col md:flex-row gap-8">
                        {/* Image Section */}
                        <div className="md:w-1/2 relative">
                            <div className="absolute inset-0 rounded-lg border-4 border-blue-500 transition-transform hover:scale-105"></div>
                            <img
                                src={`http://localhost:8000/storage/images/${bird.image}`}
                                alt={`Cockfighting Chicken owned by ${bird.owner}`}
                                className="w-full h-auto rounded-lg object-cover shadow-md relative hover:shadow-2xl transition duration-300"
                            />
                        </div>

                        {/* General Details Section */}
                        <div className="md:w-1/2 space-y-6">
                            <div className="flex items-center">
                                <span className="font-bold text-gray-700 w-32">Breed:</span>
                                <span className="text-gray-600">{bird.breed}</span>
                            </div>
                            <div className="flex items-center">
                                <span className="font-bold text-gray-700 w-32">Owner:</span>
                                <span className="text-gray-600">{bird.owner}</span>
                            </div>
                            <div className="flex items-center">
                                <span className="font-bold text-gray-700 w-32">Handler:</span>
                                <span className="text-gray-600">{bird.handler}</span>
                            </div>
                            <div className="flex items-center">
                                <span className="font-bold text-gray-700 w-32">Added to the farm:</span>
                                <span className="text-gray-600">
                                    {new Date(bird.created_at).toLocaleDateString()}
                                </span>
                            </div>
                            <div className="flex flex-col sm:flex-row items-start sm:items-center p-4 bg-gray-50 rounded-lg shadow-md">
                                <div className="sm:w-32 mb-2 sm:mb-0">
                                    <span className="font-semibold text-gray-700 text-lg">Interested?</span>
                                </div>

                                
                                <div className="flex-1 text-gray-600 leading-relaxed mb-2 sm:mb-0">
                                    <p className="text-gray-700">
                                        Picture the details of the bird and contact the handler below:
                                    </p>
                                </div>

                                
                                
                            </div>
                            <div>
                                    <a 
                                        href={`https://mail.google.com/mail/?view=cm&fs=1&to=${bird.handler}@gmail.com`}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="inline-block text-blue-600 hover:text-blue-800 hover:underline transition-all duration-300"
                                    >
                                        Email {bird.handler}@gmail.com
                                    </a>
                                </div>
                        </div>
                        
                    </div>

                    {/* Fighting Details */}
                    <div className="mt-10 space-y-10">
                        {/* Fighting History */}
                        <div>
                            <h2 className="text-2xl font-bold text-gray-800 mb-4">Fighting History</h2>
                            <div className="grid grid-cols-3 gap-4">
                                <div className="p-4 bg-green-100 rounded-lg shadow-md text-center hover:shadow-lg transition">
                                    <h3 className="text-xl font-bold text-green-600">Wins</h3>
                                    <p className="text-gray-700 text-2xl font-semibold">
                                        {getFightingHistory(bird).wins}
                                    </p>
                                </div>
                                <div className="p-4 bg-red-100 rounded-lg shadow-md text-center hover:shadow-lg transition">
                                    <h3 className="text-xl font-bold text-red-600">Losses</h3>
                                    <p className="text-gray-700 text-2xl font-semibold">
                                        {getFightingHistory(bird).losses}
                                    </p>
                                </div>
                                <div className="p-4 bg-yellow-100 rounded-lg shadow-md text-center hover:shadow-lg transition">
                                    <h3 className="text-xl font-bold text-yellow-600">Draws</h3>
                                    <p className="text-gray-700 text-2xl font-semibold">
                                        {getFightingHistory(bird).draws}
                                    </p>
                                </div>
                            </div>
                        </div>

                       

                        {/* Fitness Level */}
                        <div>
                            <h2 className="text-2xl font-bold text-gray-800 mb-4">Fitness Level</h2>
                            <p className="text-gray-600 bg-gray-50 p-4 rounded-lg shadow-md hover:shadow-lg border-l-4 border-blue-500">
                                {bird.fitness_level || 'No fitness information available.'}
                            </p>
                        </div>

                        {/* Diet Information */}
                        <div>
                            <h2 className="text-2xl font-bold text-gray-800 mb-4">Diet Information</h2>
                            <p className="text-gray-600 bg-gray-50 p-4 rounded-lg shadow-md hover:shadow-lg border-l-4 border-purple-500">
                                {bird.diet || 'No diet information available.'}
                            </p>
                        </div>
                    </div>
                </div>

                {/* Bottom Decorative Element */}
                <div className="absolute bottom-0 left-0 bg-purple-200 w-40 h-40 rounded-full translate-y-1/2 -translate-x-1/2 shadow-lg animate-pulse"></div>
            </div>
        </div>
    );
}
