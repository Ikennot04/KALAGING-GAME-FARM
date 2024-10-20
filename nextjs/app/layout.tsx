import Link from 'next/link';
import './globals.css'; // Assuming you have global styles

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="en">
      <head>
        {/* Add the Material Icons link here */}
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
      </head>
      <body>
        <header className="bg-white shadow-md p-4">
          <h1 className="text-4xl font-extrabold text-center text-blue-600 mb-4">
            KALAGING GAMEFARM
          </h1>
          <nav className="flex justify-between items-center">
            <ul className="flex space-x-6">
              <li>
                <Link href="/" className="text-gray-700 hover:text-blue-600">
                  HOME
                </Link>
              </li>
              <li>
                <Link href="/dashboard" className="text-gray-700 hover:text-blue-600">
                  DASHBOARD
                </Link>
              </li>
              <li>
                <Link href="/statistic" className="text-gray-700 hover:text-blue-600">
                  STATISTIC
                </Link>
              </li>
              <li>
                <Link href="/aboutus" className="text-gray-700 hover:text-blue-600">
                  ABOUT US
                </Link>
              </li>
            </ul>
            <form className="flex items-center space-x-2">
              <input
                type="text"
                placeholder="Search..."
                className="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
              <button
                type="submit"
                className="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
              >
                Search
              </button>
            </form>
          </nav>
        </header>
        <main>{children}</main>
      </body>
    </html>
  );
}
