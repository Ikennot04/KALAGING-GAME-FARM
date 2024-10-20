'use client';
import Image from "next/image";
import Link from "next/link";

export default function PinaBirdDetails({
    params,
}: {
    params: { birdId: string };
}) {
    return (
        <div>
            <h1 className="text-2xl font-bold mb-4">Details about Bird {params.birdId}</h1>
            <p>DETAILS</p>
            <div className="flex items-start space-x-6">
                <Image src="/MANOK.png" width={350} height={250} alt="" />
                <div>
                    <label htmlFor="breed" className="block text-lg mb-2">
                        <span className="font-bold">BREED:</span> Talisayon
                    </label>
                    <label htmlFor="owner" className="block text-lg mb-2">
                        <span className="font-bold">Owner:</span> John Doe
                    </label>
                    <label htmlFor="handler" className="block text-lg mb-2">
                        <span className="font-bold">Handler:</span> Jane Smith
                    </label>
                    <label htmlFor="timeIn" className="block text-lg mb-2">
                        <span className="font-bold">TIME IN:</span> DATE
                    </label>
                    <label htmlFor="win" className="block text-lg mb-2">
                        <span className="font-bold">WIN:</span> 0
                    </label>
                    <Link href={`/birds/edit/${params.birdId}`} key={params.birdId}>
                        <button className="bg-blue-500 text-white flex space-x-2 px-4 py-2 rounded-md mt-4">
                            <span>UPDATE</span>
                        </button>
                    </Link>
                    <Link href='/'>
                        <button className="bg-red-500 text-white flex space-x-2 px-4 py-2 rounded-md mt-4">
                            <span>BACK</span>
                        </button>
                    </Link>
                </div>
            </div>
        </div>
    );
}
