<nav class="bg-white shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800">
                    Management System
                </a>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" 
                       class="px-3 py-2 rounded-md {{ request()->routeIs('home') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        Home
                    </a>
                    <a href="{{ route('workers.index') }}" 
                       class="px-3 py-2 rounded-md {{ request()->routeIs('workers.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        Workers
                    </a>
                    <a href="{{ route('birds.index') }}" 
                       class="px-3 py-2 rounded-md {{ request()->routeIs('birds.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        Birds
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
