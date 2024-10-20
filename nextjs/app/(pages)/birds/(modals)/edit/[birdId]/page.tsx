import React from 'react';
import Image from 'next/image';
import Link from 'next/link';

function EditBirdDetails({
    params,
}: {
    params: { birdId: string };
}) {
    return (
        <div className="p-6 bg-gray-100 rounded-lg shadow-md">
            <h1 className="text-3xl font-bold mb-4">Details about Bird {params.birdId}</h1>
            <p className="text-lg mb-4">EDIT DETAILS</p>
            <div className="flex items-start space-x-8">
                <Image src="/MANOK.png" width={350} height={250} alt="" className="rounded-lg shadow" />
                
                <div className="space-y-4">
                    {/* Static Information */}
                    <div className="grid grid-cols-2 gap-4">
                        <div>
                            <label htmlFor="static-breed" className="block text-lg font-semibold">BREED:</label>
                            <p id="static-breed" className="text-gray-600">Talisayon</p>
                        </div>
                        <div>
                            <label htmlFor="breed" className="block text-lg font-semibold">Edit BREED:</label>
                            <input
                                type="text"
                                id="breed"
                                placeholder='Talisayon'
                                className="border border-gray-300 rounded p-2 mt-2 w-full"
                            />
                        </div>
                        <div>
                            <label htmlFor="static-owner" className="block text-lg font-semibold">Owner:</label>
                            <p id="static-owner" className="text-gray-600">John Doe</p>
                        </div>
                        <div>
                            <label htmlFor="owner" className="block text-lg font-semibold">Edit Owner:</label>
                            <input
                                type="text"
                                id="owner"
                                placeholder='Kentoy'
                                className="border border-gray-300 rounded p-2 mt-2 w-full"
                            />
                        </div>
                        <div>
                            <label htmlFor="static-handler" className="block text-lg font-semibold">Handler:</label>
                            <p id="static-handler" className="text-gray-600">Jane Smith</p>
                        </div>
                        <div>
                            <label htmlFor="handler" className="block text-lg font-semibold">Edit Handler:</label>
                            <input
                                type="text"
                                id="handler"
                                placeholder='BRIAN'
                                className="border border-gray-300 rounded p-2 mt-2 w-full"
                            />
                        </div>
                        <div>
                            <label htmlFor="static-timeIn" className="block text-lg font-semibold">TIME IN:</label>
                            <p id="static-timeIn" className="text-gray-600">DATE</p>
                        </div>
                        <div>
                            <label htmlFor="win" className="block text-lg font-semibold">WIN:</label>
                            
                            <input
                                type="number"
                                id="win"
                                placeholder='0'
                                className="border border-gray-300 rounded p-2 mt-2 w-full"
                            />
                        </div>
                    </div>
                    <div className="flex justify-end">
                        <Link href={`/birds/${params.birdId}`} key={params.birdId}>
                            <button className="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">
                                <span>DONE</span>
                            </button>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default EditBirdDetails;
