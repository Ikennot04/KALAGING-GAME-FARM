<nav class="bg-white shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-8">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <span class="text-xl font-bold text-gray-800">Management System</span>
                </a>
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('home') }}" 
                       class="nav-link px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('home') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('workers.index') }}" 
                       class="nav-link px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('workers.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        Workers
                    </a>
                    <a href="{{ route('birds.index') }}" 
                       class="nav-link px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('birds.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        Birds
                    </a>
                    <a href="{{ route('birds.archive') }}" 
                       class="nav-link px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('birds.archive') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        Archived Birds
                    </a>
                    <a href="{{ route('workers.archive') }}" 
                       class="nav-link px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('workers.archive') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        Archived Workers
                    </a>
                </div>
            </div>
            
            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" class="mobile-menu-button p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile menu -->
    <div class="mobile-menu hidden md:hidden">
        <a href="{{ route('home') }}" 
           class="block px-4 py-2 text-sm {{ request()->routeIs('home') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
            Dashboard
        </a>
        <a href="{{ route('workers.index') }}" 
           class="block px-4 py-2 text-sm {{ request()->routeIs('workers.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
            Workers
        </a>
        <a href="{{ route('birds.index') }}" 
           class="block px-4 py-2 text-sm {{ request()->routeIs('birds.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
            Birds
        </a>
        <a href="{{ route('birds.archive') }}" 
           class="block px-4 py-2 text-sm {{ request()->routeIs('birds.archive') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
            Archived Birds
        </a>
        <a href="{{ route('workers.archive') }}" 
           class="block px-4 py-2 text-sm {{ request()->routeIs('workers.archive') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
            Archived Workers
        </a>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenuButton.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
    });
});
</script>
