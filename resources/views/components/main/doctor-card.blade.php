<div
    class="max-w-2xl mx-4 sm:max-w-sm md:max-w-sm lg:max-w-sm xl:max-w-sm sm:mx-auto md:mx-auto lg:mx-auto xl:mx-auto mt-16 bg-white shadow-xl rounded-lg text-gray-900">
    <div class="rounded-t-lg h-32 overflow-hidden">
        <img class="object-cover object-top w-full"
            src='{{ $doctor->cover_url }}'
            alt='Mountain'>
    </div>
    <div class="mx-auto w-32 h-32 relative -mt-16 border-4 border-white rounded-full overflow-hidden">
        <img class="object-cover object-center h-32"
            src='{{ $doctor->profile_photo_url }}'
            alt='Woman looking front'>
    </div>
    <div class="text-center mt-2">
        <a href="{{ route('doctors.show', ['user' => $doctor->id]) }}" class="flex hover:underline hover:text-sky-500 anim-300 gap-2 items-center justify-center">
            <i class="bi bi-person-fill"></i>
            <h2 class="font-semibold text-xl capitalize"> {{ $doctor->name }} </h2>
        </a>
        <p class="text-gray-500 uppercase">{{ $doctor->speciality }}</p>
    </div>
    <ul class="py-4 mt-2 text-gray-700 flex items-center justify-around">
        <li class="flex flex-col items-center justify-around">
            <svg class="w-4 fill-current text-blue-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path
                    d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
            </svg>
            <div>2k</div>
        </li>
        <li class="flex flex-col items-center justify-between">
            <svg class="w-4 fill-current text-blue-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path
                    d="M7 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1c2.15 0 4.2.4 6.1 1.09L12 16h-1.25L10 20H4l-.75-4H2L.9 10.09A17.93 17.93 0 0 1 7 9zm8.31.17c1.32.18 2.59.48 3.8.92L18 16h-1.25L16 20h-3.96l.37-2h1.25l1.65-8.83zM13 0a4 4 0 1 1-1.33 7.76 5.96 5.96 0 0 0 0-7.52C12.1.1 12.53 0 13 0z" />
            </svg>
            <div>10k</div>
        </li>
        <li class="flex flex-col items-center justify-around">
            <svg class="w-4 fill-current text-blue-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path
                    d="M9 12H1v6a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-6h-8v2H9v-2zm0-1H0V5c0-1.1.9-2 2-2h4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1h4a2 2 0 0 1 2 2v6h-9V9H9v2zm3-8V2H8v1h4z" />
            </svg>
            <div>15</div>
        </li>
    </ul>

    <div class="p-2">
        <p class="text-black text-sm px-4 text-center ">
            As an experienced Cardiologue doctor, I provide compassionate, patient-centered care. Committed to staying updated with medical advancements, I create individualized treatment plans to improve patient outcomes. My goal is to enhance quality of life through effective communication and collaboration with patients and healthcare teams.
        </p>
    </div>
    
    <div class="my-2 flex justify-center text-sm gap-2">
        <button class="block flex items-center gap-1 rounded-full bg-gray-900 hover:shadow-lg font-semibold text-white px-6 py-2">
            <i class="bi bi-plus-lg"></i>Follow
        </button>
        <button class="block flex items-center gap-1 rounded-full bg-gray-300 hover:shadow-lg font-semibold text-slate-700 px-6 py-2">
            <i class="bi bi-chat"></i> message
        </button>
    </div>
</div>
