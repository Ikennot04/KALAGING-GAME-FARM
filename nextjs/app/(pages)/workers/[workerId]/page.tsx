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
                    throw new Error('Worker not found');
                }
                const data = await response.json();
                setWorker(data);
            } catch (err) {
                setError(err instanceof Error ? err.message : 'Failed to load worker details');
            } finally {
                setLoading(false);
            }
        };

        fetchWorkerDetails();
    }, [params.workerId]);

    if (loading) {
        return <div className="p-8">Loading worker details...</div>;
    }

    if (error || !worker) {
        return <div className="p-8 text-red-500">Error: {error || 'Worker not found'}</div>;
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
                
                <h1 className="text-3xl font-bold mb-6">Worker Details</h1>
                
                <div className="bg-white rounded-lg shadow-lg p-6">
                    <div className="flex flex-col md:flex-row gap-8">
                        <div className="md:w-1/2">
                            <img
                                src={`http://localhost:8000/storage/images/${worker.image}`}
                                alt={`${worker.name}`}
                                className="w-full h-auto rounded-lg object-cover"
                            />
                        </div>
                        
                        <div className="md:w-1/2 space-y-4">
                            <div>
                                <span className="font-bold text-gray-700">Name:</span>
                                <span className="ml-2">{worker.name}</span>
                            </div>
                            <div>
                                <span className="font-bold text-gray-700">Position:</span>
                                <span className="ml-2">{worker.position}</span>
                            </div>
                            <div>
                                <span className="font-bold text-gray-700">Created:</span>
                                <span className="ml-2">{new Date(worker.created_at).toLocaleDateString()}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
} 