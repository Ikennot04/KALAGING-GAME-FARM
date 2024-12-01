'use client'
import { useState, useEffect } from 'react';

export interface Worker {
    id: string;
    name: string;
    position: string;
    image: string;
    created_at: string;
    updated_at: string;
    deleted: boolean;
}

export const useWorkers = () => {
    const [workers, setWorkers] = useState<Worker[]>([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);

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
                const activeWorkers = data.workers.filter((worker: Worker) => 
                    worker && 
                    !worker.deleted && 
                    worker.image
                );

                if (activeWorkers.length === 0) {
                    throw new Error('No active workers found');
                }

                setWorkers(activeWorkers);
                setLoading(false);
            } catch (error) {
                console.error('Error fetching data:', error);
                setError('Failed to load content');
                setLoading(false);
            }
        };

        // Set up interval to fetch data every 3 seconds
        const interval = setInterval(fetchData, 3000);

        // Initial fetch
        fetchData();

        // Cleanup interval on component unmount
        return () => clearInterval(interval);
    }, []);

    return { workers, loading, error };
};