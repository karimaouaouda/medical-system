<x-filament::page>
    @vite('resources/css/app.css')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Profile Header -->
        <div class="relative h-48 bg-gradient-to-r from-blue-500 to-blue-600">
            <div class="absolute -bottom-16 left-8">
                <div class="h-32 w-32 rounded-full border-4 border-white overflow-hidden bg-white">
                    <img src="{{ $record->profile_photo_url }}"
                         alt="{{ $record->name }}"
                         class="h-full w-full object-cover">
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="pt-20 pb-8 px-8">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between">
                <!-- Left Column -->
                <div class="flex-1">
                    <div class="flex items-center space-x-4">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $record->name }}</h1>
                        <span class="px-3 mx-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                            {{ $record->profile?->specialty?->name ?? "Generalist" }}
                        </span>
                    </div>

                    <!-- Stats -->
                    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $record->patients_count }}</div>
                            <div class="text-sm text-gray-500">Patients</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $record->experience_years }}</div>
                            <div class="text-sm text-gray-500">Years Experience</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $record->rating }}</div>
                            <div class="text-sm text-gray-500">Rating</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $record->reviews_count }}</div>
                            <div class="text-sm text-gray-500">Reviews</div>
                        </div>
                    </div>

                    <!-- Bio -->
                    <div class="mt-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">About</h2>
                        <p class="text-gray-600 whitespace-pre-line">{{ $record->bio }}</p>
                    </div>

                    <!-- Contact Information -->
                    <div class="mt-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h2>
                        <div class="space-y-3">
                            <div class="flex items-center text-gray-600">
                                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $record->full_address }}
                            </div>
                            <div class="flex items-center text-gray-600">
                                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $record->contact->email }}
                            </div>
                            <div class="flex items-center text-gray-600">
                                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $record->contact->phone_number }}
                            </div>
                        </div>
                    </div>

                    <!-- Working Hours -->
                    <div class="mt-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Working Hours</h2>
                        <div class="space-y-2">
                            @foreach(json_decode($record->profile->work_hours, true) as $key => $hours)
                                <div class="flex justify-between text-gray-600">
                                    <span class="font-medium">{{ $hours['day'] }}</span>
                                    <span>{{ $hours['from_hour'] }} - {{ $hours['to_hour'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="mt-8 md:mt-0 md:ml-8 space-y-4">
                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        @auth
                            @if(auth()->user()->isFollowing($record))
                                <x-filament::button
                                    wire:click="unfollowDoctor"
                                    class="w-full"
                                    color="gray">
                                    <x-slot name="icon">
                                        <x-heroicon-o-user-minus/>
                                    </x-slot>
                                    unfollow
                                </x-filament::button>
                            @elseif(auth()->user()->hasPendingRequestFor($record))
                                <x-filament::button
                                    wire:click="cancelRequest"
                                    class="w-full"
                                    color="warning">
                                    <x-slot name="icon">
                                        <x-heroicon-o-user-plus/>
                                    </x-slot>
                                    cancel request
                                </x-filament::button>
                            @else
                                <x-filament::button
                                    wire:click="followDoctor"
                                    class="w-full"
                                    color="info">
                                    <x-slot name="icon">
                                        <x-heroicon-o-user-plus/>
                                    </x-slot>
                                    follow
                                </x-filament::button>
                            @endif

                        <x-filament::button
                            href="{{ url('chatify/' . $record->id) }}"
                            tag="a"
                            color="success"
                            class="w-full">
                            <x-slot name="icon">
                                <x-heroicon-o-chat-bubble-left-ellipsis/>
                            </x-slot>

                            send message
                        </x-filament::button>
                        @else
                            <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Login to Follow
                            </a>
                        @endauth
                    </div>

                    <!-- Quick Stats -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Quick Stats</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Response Time</span>
                                <span class="text-gray-900">2h</span>
                            </div>

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Languages</span>
                                <span class="text-gray-900">{{ implode(', ', $record->languages_array) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mt-8 bg-white rounded-lg shadow-lg p-8">
        <div class="w-full flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Patient Reviews</h2>
            <x-filament::modal>
                <x-slot name="trigger">
                    <x-filament::button>
                        <x-slot name="icon">
                            <x-heroicon-o-squares-plus/>
                        </x-slot>
                        add review
                    </x-filament::button>
                </x-slot>

                <x-slot name="heading">
                    Add Review
                </x-slot>


                <x-slot name="description">
                    Share your experience with this doctor by writing a review. Your feedback helps others make
                    informed decisions.
                </x-slot>

                {{ $this->review_form }}
            </x-filament::modal>
        </div>
        <div class="space-y-6">
            @forelse($record->profile->reviews as $review)
                <div class="border-b border-gray-200 pb-6 last:border-0 last:pb-0">
                    <div class="flex items-center mb-4">
                        <img src="{{ $review->patient->profile_photo_url }}"
                             alt="{{ $review->patient->name }}"
                             class="h-10 w-10 rounded-full">
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">{{ $review->patient->name }}</h4>
                            <div class="flex items-center">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="h-4 w-4 {{ $i <= $review->rate ? 'text-yellow-400' : 'text-gray-300' }}"
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="ml-2 text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">{{ $review->comment }}</p>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">No reviews yet.</p>
            @endforelse
        </div>
    </div>
    </div>
</x-filament::page>
