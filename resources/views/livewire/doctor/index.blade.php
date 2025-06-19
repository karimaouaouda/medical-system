<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Search Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form action="#" method="GET" class="space-y-4">
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Search Input -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Doctors</label>
                    <div class="relative">
                        <input type="text" name="search" id="search"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Search by name, specialty, or location"
                            value="{{ request('search') }}">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Specialty Filter -->
                <div class="w-full md:w-64">
                    <label for="specialty" class="block text-sm font-medium text-gray-700 mb-1">Specialty</label>
                    <select name="specialty" id="specialty"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Specialties</option>
                        <option value="cardiology" {{ request('specialty') == 'cardiology' ? 'selected' : '' }}>Cardiology</option>
                        <option value="dermatology" {{ request('specialty') == 'dermatology' ? 'selected' : '' }}>Dermatology</option>
                        <option value="neurology" {{ request('specialty') == 'neurology' ? 'selected' : '' }}>Neurology</option>
                        <option value="pediatrics" {{ request('specialty') == 'pediatrics' ? 'selected' : '' }}>Pediatrics</option>
                        <option value="psychiatry" {{ request('specialty') == 'psychiatry' ? 'selected' : '' }}>Psychiatry</option>
                    </select>
                </div>

                <!-- Sort By -->
                <div class="w-full md:w-48">
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                    <select name="sort" id="sort"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                        <option value="patients" {{ request('sort') == 'patients' ? 'selected' : '' }}>Most Patients</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Search
                </button>
            </div>
        </form>
    </div>

    <!-- Results Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($doctors as $doctor)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img class="h-16 w-16 rounded-full object-cover"
                            src="{{ $doctor->profile_photo_url }}"
                            alt="{{ $doctor->name }}">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-semibold text-gray-900 truncate">
                            {{ $doctor->name }}
                        </h3>
                        <p class="text-sm text-gray-500">{{ $doctor->specialty ?? 'Generalist' }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-sm text-gray-600 line-clamp-3">
                        {{ $doctor->bio ?? "my bio is something i do" }}
                    </p>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm text-gray-500">{{ $doctor->patients_count ?? 10 }} Patients</span>
                    </div>
                    <a href="{{ route('doctor.show', $doctor) }}"
                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        View Profile
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No doctors found</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($doctors->hasPages())
    <div class="mt-8">
        {{ $doctors->links() }}
    </div>
    @endif
</div>