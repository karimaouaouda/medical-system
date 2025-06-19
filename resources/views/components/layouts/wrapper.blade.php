<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Medical') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen flex flex-col bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                            Medical
                        </a>
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900">Home</a>
                        <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-900">About Us</a>
                        <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-900">FAQ</a>
                        <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-900">Contact</a>
                    </div>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="ml-4 bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Register</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="sm:hidden hidden mobile-menu">
            <div class="pt-2 pb-3 space-y-1">
                <a href="#" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-900">Home</a>
                <a href="#" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-500 hover:text-gray-900">About Us</a>
                <a href="#" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-500 hover:text-gray-900">FAQ</a>
                <a href="#" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-500 hover:text-gray-900">Contact</a>
            </div>
            <div class="pt-4 pb-3 border-t border-gray-200">
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 text-base font-medium text-gray-500 hover:text-gray-900">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-500 hover:text-gray-900">Login</a>
                    <a href="{{ route('register') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-500 hover:text-gray-900">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-lg mt-auto">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">About Us</h3>
                    <p class="text-gray-600">Providing quality healthcare solutions for everyone.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-gray-900">Home</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-gray-900">About Us</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-gray-900">FAQ</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-gray-900">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Info</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>Email: info@medical.com</li>
                        <li>Phone: +1 234 567 890</li>
                        <li>Address: 123 Medical Street</li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-200">
                <p class="text-center text-gray-500">&copy; {{ date('Y') }} Medical. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Mobile menu JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const mobileMenu = document.querySelector('.mobile-menu');

            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>

@livewireScripts
</body>
</html>
