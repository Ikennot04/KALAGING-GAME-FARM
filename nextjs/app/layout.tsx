'use client'
import { useState, useEffect } from 'react';
import Link from 'next/link';
import './globals.css'; // Assuming you have global styles
import Image from 'next/image';
import Search from './Components/Search';
import IntroVideo from './Components/IntroVideo';

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  const [hasVisited, setHasVisited] = useState(false);

  useEffect(() => {
    // Check if user has visited before
    const visited = localStorage.getItem('hasVisited');
    setHasVisited(!!visited);
    
    // Set visited flag
    if (!visited) {
      localStorage.setItem('hasVisited', 'true');
    }
  }, []);

  return (
    <html lang="en">
      <head>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
      </head>
      <body className="moving-background bg-gradient-to-r from-blue-400 to-blue-600">
        {!hasVisited && <IntroVideo />}
        <header className="bg-white shadow-md p-4 flex items-center justify-center">
          <h1 className="text-4xl font-extrabold text-blue-600 mr-4">
            KALAGING GAMEFARM
          </h1>
          <Image 
            src="/triangle.gif" // Path to your GIF
            alt="Triangle Animation"
            width={50} // Set your desired width
            height={50} // Set your desired height
            className="rounded" // Optional: Add rounded corners to the GIF
          />
        </header>
        
        {/* Navigation Bar */}
        <nav className="bg-white shadow-md py-2">
          <div className="container mx-auto flex justify-between items-center px-4">
            <ul className="flex space-x-6">
              <li>
                <Link href="/" className="text-gray-700 hover:text-blue-600 transition-colors duration-200 flex items-center space-x-2">
                  <span className="material-icons text-lg">bird</span>
                  <span>BIRDS</span>
                </Link>
              </li>
              <li>
                <Link href="/dashboard" className="text-gray-700 hover:text-blue-600 transition-colors duration-200 flex items-center space-x-2">
                  <span className="material-icons text-lg">dashboard</span>
                  <span>DASHBOARD</span>
                </Link>
              </li>
              {/* <li>
                <Link href="/statistic" className="text-gray-700 hover:text-blue-600 transition-colors duration-200 flex items-center space-x-2">
                  <span className="material-icons text-lg">assessment</span>
                  <span>STATISTIC</span>
                </Link>
              </li> */}
              <li>
                <Link href="/aboutus" className="text-gray-700 hover:text-blue-600 transition-colors duration-200 flex items-center space-x-2">
                  <span className="material-icons text-lg">info</span>
                  <span>ABOUT US</span>
                </Link>
              </li>
            </ul>
            <div className="flex items-center space-x-2">
              <Search />
            </div>
          </div>
        </nav>
        
        <main className="py-8 px-4">{children}</main>
      </body>
    </html>
  );
}
