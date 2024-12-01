'use client';
import { useState, useEffect } from 'react';
import { useRouter } from 'next/navigation';

interface Worker {
    id: number;
    name: string;
    position: string;
    image: string;
    created_at: string;
}

export default function WorkerDetails({
    params,
}: {
    params: { workerId: string };
}) {
    const router = useRouter();
    const [worker, setWorker] = useState<Worker | null>(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        const fetchWorkerDetails = async () => {
            try {
                const response = await fetch(`http://localhost:8000/api/workers/${params.workerId}`);
                if (!response.ok) {
                    throw new Error('Handler not found');
                }
                const data = await response.json();
                setWorker(data);
            } catch (err) {
                setError(err instanceof Error ? err.message : 'Failed to load handler details');
            } finally {
                setLoading(false);
            }
        };

        fetchWorkerDetails();
    }, [params.workerId]);

    if (loading) {
        return <div className="p-8 text-center text-xl">Loading handler details...</div>;
    }

    if (error || !worker) {
        return <div className="p-8 text-center text-red-600 text-xl">Error: {error || 'Handler not found'}</div>;
    }

    return (
        <div className="p-8 bg-gray-100 min-h-screen">
            <div className="max-w-4xl mx-auto bg-white rounded-lg shadow-xl p-8">
                <button 
                    onClick={() => router.back()} 
                    className="mb-6 text-lg text-indigo-600 hover:text-indigo-800 transition-all duration-300"
                >
                    ← Back to List
                </button>

                <h1 className="text-4xl font-bold text-center text-indigo-800 mb-8">Handler Details</h1>
                
                <div className="flex flex-col md:flex-row gap-8">
                    <div className="md:w-1/2">
                        <img
                            src={`http://localhost:8000/storage/images/${worker.image}`}
                            alt={`${worker.name}`}
                            className="w-full h-auto rounded-lg shadow-lg object-cover"
                        />
                    </div>

                    <div className="md:w-1/2 space-y-6">
                        <div className="flex flex-col space-y-4">
                            <div className="flex items-center">
                                <span className="font-semibold text-gray-800 text-lg">Name:</span>
                                <span className="ml-4 text-gray-700">{worker.name}</span>
                            </div>
                            <div className="flex items-center">
                                <span className="font-semibold text-gray-800 text-lg">Position:</span>
                                <span className="ml-4 text-gray-700">{worker.position}</span>
                            </div>
                            <div className="flex items-center">
                                <span className="font-semibold text-gray-800 text-lg">Joined:</span>
                                <span className="ml-4 text-gray-700">{new Date(worker.created_at).toLocaleDateString()}</span>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    );
}
