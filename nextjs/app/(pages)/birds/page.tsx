import { useState, useEffect } from 'react';

interface Bird {
  id: number;
  owner: string;
  image: string;
  handler: string;
  breed: string;
  created_at: string;
}

const BirdList: React.FC = () => {
  const [birds, setBirds] = useState<Bird[]>([]); // Initialize as an empty array
  const [currentPage, setCurrentPage] = useState<number>(1);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);

  const itemsPerPage = 20;

  useEffect(() => {
    const fetchBirds = async () => {
      try {
        setLoading(true);
        const response = await fetch('http://localhost:8000/api/birds');
        if (!response.ok) {
          throw new Error(`Error: ${response.statusText}`);
        }
        const data = await response.json();
        setBirds(Array.isArray(data) ? data : data.birds || []);
        setError(null);
      } catch (err) {
        setError(err instanceof Error ? err.message : 'An unexpected error occurred');
        setBirds([]);
      } finally {
        setLoading(false);
      }
    };

    fetchBirds();
  }, []);

  const totalPages = Math.ceil(birds.length / itemsPerPage);

  const handlePageChange = (page: number) => {
    setCurrentPage(page);
  };

  const startIndex = (currentPage - 1) * itemsPerPage;
  const selectedBirds = birds.slice(startIndex, startIndex + itemsPerPage);

  if (loading) {
    return <div className="text-center mt-8">Loading birds...</div>;
  }

  if (error) {
    return <div className="text-center mt-8 text-red-500">Error: {error}</div>;
  }

  return (
    <div className="p-8 font-sans">
      <h1 className="text-2xl font-bold text-center mb-8">Bird List</h1>
      <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        {selectedBirds.map((bird) => (
          <div
            key={bird.id}
            className="border rounded-lg overflow-hidden bg-white shadow-md hover:shadow-lg transition-shadow"
          >
            <img
              src={`http://localhost:8000/storage/images/${bird.image}`}
              alt={`Bird owned by ${bird.owner}`}
              className="w-full h-48 object-cover"
              
            />
            <div className="p-4">
              <p className="font-semibold text-center">{bird.owner}</p>
              <p className="text-sm text-center text-gray-500">Handler: {bird.handler}</p>
              <p className="text-sm text-center text-gray-500">Breed: {bird.breed}</p>
              <p className="text-sm text-center text-gray-500">Created: {bird.created_at}</p>
            </div>
          </div>
        ))}
      </div>
      <div className="flex justify-center mt-8">
      {Array.from({ length: totalPages }, (_, index) => (
          <button
            key={index}
            onClick={() => handlePageChange(index + 1)}
            className={`px-4 py-2 mx-1 rounded-lg text-white ${
              index + 1 === currentPage
                ? 'bg-blue-500'
                : 'bg-gray-300 hover:bg-gray-400'
            }`}
          >
            {index + 1}
          </button>
        ))}
      </div>
    </div>
  );
};

export default BirdList;
