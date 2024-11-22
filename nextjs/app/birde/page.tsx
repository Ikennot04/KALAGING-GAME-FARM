"use client"
import { useEffect, useState } from 'react';

export default function Birds() {
  const [birds, setBirds] = useState([]); // State to hold bird data
  const [loading, setLoading] = useState(true); // State to track loading status
  const [error, setError] = useState(null); // State to track errors

  useEffect(() => {
    // Fetch data from the Laravel API
    const fetchBirds = async () => {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/birds'); // Replace with your API URL
        if (!response.ok) {
          throw new Error(`Failed to fetch birds: ${response.status}`);
        }
        const data = await response.json(); // Parse response
        setBirds(data.data || []); // Extract bird data (assumes `data` key)
      } catch (err) {
        setError('Error fetching birds.');
        console.error(err);
      } finally {
        setLoading(false); // Stop loading
      }
    };

    fetchBirds(); // Fetch birds on component mount
  }, []);

  // Show loading state
  if (loading) return <p>Loading...</p>;

  // Show error state
  if (error) return <p>{error}</p>;

  // Render bird data
  return (
    <div>
      <h1>Birds List</h1>
      {birds.length > 0 ? (
        <ul>
          {birds.map((bird) => (
            <li key={bird.id}>
              ID: {bird.id}, Owner: {bird.owner}, Handler: {bird.handler}, Breed: {bird.breed}
            </li>
          ))}
        </ul>
      ) : (
        <p>No birds found.</p>
      )}
    </div>
  );
}
