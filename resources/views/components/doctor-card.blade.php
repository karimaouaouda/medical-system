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
                <p class="text-sm text-gray-500">{{ $doctor->profile->speciality->name ?? 'Generalist' }}</p>
            </div>
        </div>

        <div class="mt-4">
            <p class="text-sm text-gray-600 line-clamp-3">
                {{ $doctor->profile->biography ?? "my bio is something i do" }}
            </p>
        </div>

        <div class="mt-4 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="text-sm text-gray-500">{{ $doctor->patients_count ?? 10 }} Patients</span>
            </div>
            <a href="{{ route('filament.patient.resources.doctors.view', ['record' => $doctor->id]) }}"
                class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                View Profile
            </a>
        </div>
    </div>
</div>
