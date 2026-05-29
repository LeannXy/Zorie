@extends('layouts.app')

@section('content')

    @include('pages.home.sections.navbar')

    <div class="min-h-screen bg-white pt-32 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb with Back Button -->
            <div class="mb-8 flex items-center gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-gray-600 hover:text-gray-900 font-semibold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back
                </a>
                <span class="text-gray-300">/</span>
                <span class="text-gray-600">My Account</span>
            </div>

            @if(auth()->check())
                <!-- Logged In User View -->
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    <!-- Left Sidebar - Navigation -->
                    <div class="lg:col-span-1">
                        <div class="border border-gray-200 rounded-lg p-6 sticky top-32">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Account Menu</h3>
                            <nav class="space-y-2">
                                <a href="#profile" onclick="switchTab('profile')" class="block px-4 py-2 rounded-lg bg-gray-100 text-gray-900 font-semibold hover:bg-gray-200 transition tab-link" data-tab="profile">
                                    My Profile
                                </a>
                                <a href="#orders" onclick="switchTab('orders')" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 font-semibold transition tab-link" data-tab="orders">
                                    My Orders
                                </a>
                                <a href="#settings" onclick="switchTab('settings')" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 font-semibold transition tab-link" data-tab="settings">
                                    Settings
                                </a>
                                <a href="#saved-addresses" onclick="switchTab('saved-addresses')" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 font-semibold transition tab-link" data-tab="saved-addresses">
                                    Saved Addresses
                                </a>
                                <hr class="my-4">
                                <form action="{{ route('logout') }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 rounded-lg text-gray-600 hover:bg-red-50 hover:text-red-600 font-semibold transition text-left">
                                        Logout
                                    </button>
                                </form>
                            </nav>
                        </div>
                    </div>

                    <!-- Right Content Area -->
                    <div class="lg:col-span-3">
                        <!-- Profile Tab -->
                        <div id="profile-tab" class="tab-content block">
                            <div class="border border-gray-200 rounded-lg p-8">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">My Profile</h2>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">First Name</label>
                                        <input type="text" value="{{ auth()->user()->name }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400" disabled>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Last Name</label>
                                        <input type="text" value="" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400" disabled>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                        <input type="email" value="{{ auth()->user()->email }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400" disabled>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                        <input type="tel" placeholder="Add your phone number" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400">
                                    </div>
                                </div>

                                <div class="mt-8">
                                    <h3 class="text-lg font-bold text-gray-900 mb-4">Date of Birth</h3>
                                    <input type="date" class="w-full md:w-1/2 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400">
                                </div>

                                <button class="mt-8 px-6 py-2 bg-black text-white rounded-lg font-semibold hover:bg-gray-800 transition">
                                    Save Changes
                                </button>
                            </div>
                        </div>

                        <!-- Orders Tab -->
                        <div id="orders-tab" class="tab-content hidden">
                            <div class="border border-gray-200 rounded-lg p-8">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">My Orders</h2>
                                
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    <h3 class="text-gray-900 font-semibold mb-2">No orders yet</h3>
                                    <p class="text-gray-600 text-sm mb-4">Start shopping to place your first order</p>
                                    <a href="{{ route('home') }}" class="inline-block text-gray-900 hover:text-gray-700 font-semibold">
                                        Continue Shopping
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Settings Tab -->
                        <div id="settings-tab" class="tab-content hidden">
                            <div class="border border-gray-200 rounded-lg p-8">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">Settings</h2>
                                
                                <div class="space-y-6">
                                    <div class="pb-6 border-b border-gray-200">
                                        <h3 class="text-lg font-bold text-gray-900 mb-3">Email Preferences</h3>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" checked class="w-4 h-4 rounded">
                                            <span class="ml-3 text-sm text-gray-700">Receive promotional emails</span>
                                        </label>
                                        <label class="flex items-center cursor-pointer mt-3">
                                            <input type="checkbox" checked class="w-4 h-4 rounded">
                                            <span class="ml-3 text-sm text-gray-700">Receive order updates</span>
                                        </label>
                                    </div>

                                    <div class="pb-6 border-b border-gray-200">
                                        <h3 class="text-lg font-bold text-gray-900 mb-3">Account Security</h3>
                                        <button class="px-6 py-2 border border-gray-300 text-gray-900 rounded-lg font-semibold hover:bg-gray-50 transition">
                                            Change Password
                                        </button>
                                    </div>

                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 mb-3">Danger Zone</h3>
                                        <button class="px-6 py-2 border border-red-300 text-red-600 rounded-lg font-semibold hover:bg-red-50 transition">
                                            Delete Account
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Saved Addresses Tab -->
                        <div id="saved-addresses-tab" class="tab-content hidden">
                            <div class="border border-gray-200 rounded-lg p-8">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-2xl font-bold text-gray-900">Saved Addresses</h2>
                                    <button class="px-4 py-2 bg-black text-white rounded-lg font-semibold hover:bg-gray-800 transition">
                                        + Add New Address
                                    </button>
                                </div>

                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <h3 class="text-gray-900 font-semibold mb-2">No saved addresses</h3>
                                    <p class="text-gray-600 text-sm">Add an address to make checkout faster</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Not Logged In View -->
                <div class="text-center py-16">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0z" />
                    </svg>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome to Your Account</h2>
                    <p class="text-gray-600 mb-8">Please log in or create an account to access your profile</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('login') }}" class="px-8 py-3 bg-black text-white rounded-lg font-semibold hover:bg-gray-800 transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-8 py-3 border border-gray-300 text-gray-900 rounded-lg font-semibold hover:bg-gray-50 transition">
                            Create Account
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include('pages.home.sections.footer')

    <script>
        function switchTab(tabName) {
            // Hide all tabs
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.classList.add('hidden'));

            // Remove active state from all links
            const links = document.querySelectorAll('.tab-link');
            links.forEach(link => {
                link.classList.remove('bg-gray-100', 'text-gray-900', 'font-semibold');
                link.classList.add('text-gray-600');
            });

            // Show selected tab
            const selectedTab = document.getElementById(tabName + '-tab');
            if (selectedTab) {
                selectedTab.classList.remove('hidden');
            }

            // Set active link
            const activeLink = document.querySelector(`[data-tab="${tabName}"]`);
            if (activeLink) {
                activeLink.classList.remove('text-gray-600');
                activeLink.classList.add('bg-gray-100', 'text-gray-900', 'font-semibold');
            }
        }
    </script>

@endsection
