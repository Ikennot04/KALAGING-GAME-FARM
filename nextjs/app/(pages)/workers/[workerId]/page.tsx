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

    // Static additions for handler details
    const staticDetails = {
        experience: '5 years of experience in handling championship chickens.',
        specialty: 'Expert in combat training, nutrition management, and health monitoring.',
        contact: 'handler@example.com',
        skills: [
            'Chicken health management',
            'Combat training strategies',
            'Nutritional planning',
            'Record-keeping and reporting',
        ],
        achievements: [
            {
                title: 'Best Handler 2023',
                description: 'Awarded for excellence in chicken care.',
            },
            {
                title: 'Top Trainer',
                description: 'Trained 15 championship-winning chickens.',
            },
        ],
    };

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
        return (
            <div className="p-8 min-h-screen flex items-center justify-center bg-gray-100">
                <p className="text-xl text-gray-600 animate-pulse">Loading handler details...</p>
            </div>
        );
    }

    if (error || !worker) {
        return (
            <div className="p-8 min-h-screen flex items-center justify-center bg-gray-100">
                <p className="text-xl text-red-600">Error: {error || 'Handler not found'}</p>
            </div>
        );
    }

    return (
        <div className="p-8 bg-gradient-to-tr from-blue-600 to-indigo-600 min-h-screen flex items-center justify-center">
            <div className="max-w-5xl mx-auto bg-white rounded-lg shadow-2xl overflow-hidden">
                <div className="p-6 md:p-10">
                    {/* Back Button */}
                    <button
                        onClick={() => router.back()}
                        className="mb-6 text-blue-500 hover:text-blue-700 font-medium flex items-center space-x-2 transition transform hover:scale-105"
                    >
                        ← Back to List
                    </button>

                    {/* Title */}
                    <h1 className="text-4xl font-bold text-center text-gray-800 mb-8">
                        Handler Details
                    </h1>

                    {/* Handler Details Section */}
                    <div className="flex flex-col md:flex-row gap-8">
                        {/* Image Section */}
                        <div className="md:w-1/2 relative">
                            <img
                                src={`http://localhost:8000/storage/images/${worker.image}`}
                                alt={`${worker.name}`}
                                className="w-full h-auto rounded-lg shadow-md object-cover transition-transform transform hover:scale-105"
                            />
                        </div>

                        {/* Information Section */}
                        <div className="md:w-1/2 space-y-6">
                            {/* Personal Information */}
                            <div className="space-y-4">
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
                                <div className="flex items-center">
                                    <span className="font-semibold text-gray-800 text-lg">Contact:</span>
                                    <span className="ml-4 text-gray-700">{staticDetails.contact}</span>
                                </div>
                            </div>

                            {/* Professional Information */}
                            <div className="space-y-4">
                                <div className="flex flex-col">
                                    <span className="font-semibold text-gray-800 text-lg">Experience:</span>
                                    <p className="ml-4 text-gray-700">{staticDetails.experience}</p>
                                </div>
                                <div className="flex flex-col">
                                    <span className="font-semibold text-gray-800 text-lg">Specialty:</span>
                                    <p className="ml-4 text-gray-700">{staticDetails.specialty}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Decorative Elements */}
                    <div className="mt-10 space-y-10">
                        {/* Skills Section */}
                        <div>
                            <h2 className="text-2xl font-bold text-gray-800 mb-4">Skills</h2>
                            <ul className="list-disc list-inside bg-gray-50 p-4 rounded-lg shadow-md border-l-4 border-blue-500">
                                {staticDetails.skills.map((skill, index) => (
                                    <li key={index} className="text-gray-700">
                                        {skill}
                                    </li>
                                ))}
                            </ul>
                        </div>

                        {/* Achievements */}
                        <div>
                            <h2 className="text-2xl font-bold text-gray-800 mb-4">Achievements</h2>
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {staticDetails.achievements.map((achievement, index) => (
                                    <div
                                        key={index}
                                        className="p-4 bg-green-100 rounded-lg shadow-md text-center hover:shadow-lg transition"
                                    >
                                        <h3 className="text-xl font-bold text-green-600">{achievement.title}</h3>
                                        <p className="text-gray-700">{achievement.description}</p>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
