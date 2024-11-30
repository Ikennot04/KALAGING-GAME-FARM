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

    if (loading) {
        return <div className="p-8">Loading bird details...</div>;
    }

    if (error || !bird) {
        return <div className="p-8 text-red-500">Error: {error || 'Bird not found'}</div>;
    }

    return (
        <div className="p-8">
            <div className="max-w-4xl mx-auto">
                <button 
                    onClick={() => router.back()} 
                    className="mb-4 text-blue-500 hover:text-blue-700"
                >
                    ← Back to List
                </button>
                
                <h1 className="text-3xl font-bold mb-6">Bird Details</h1>
                
                <div className="bg-white rounded-lg shadow-lg p-6">
                    <div className="flex flex-col md:flex-row gap-8">
                        <div className="md:w-1/2">
                            <img
                                src={`http://localhost:8000/storage/images/${bird.image}`}
                                alt={`Bird owned by ${bird.owner}`}
                                className="w-full h-auto rounded-lg object-cover"
                            />
                        </div>
                        
                        <div className="md:w-1/2 space-y-4">
                            <div>
                                <span className="font-bold text-gray-700">Breed:</span>
                                <span className="ml-2">{bird.breed}</span>
                            </div>
                            <div>
                                <span className="font-bold text-gray-700">Owner:</span>
                                <span className="ml-2">{bird.owner}</span>
                            </div>
                            <div>
                                <span className="font-bold text-gray-700">Handler:</span>
                                <span className="ml-2">{bird.handler}</span>
                            </div>
                            <div>
                                <span className="font-bold text-gray-700">Created:</span>
                                <span className="ml-2">{new Date(bird.created_at).toLocaleDateString()}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
