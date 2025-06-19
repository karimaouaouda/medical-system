<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});


Route::get('/messages', function(){
    return 'create0';
})->name('messages.create');

Route::get('/doctors', function(){
    return view('doctor.index');
})->name('doctor.index');

Route::get('/doctors/{user}', function(User $user){
    return view('doctor.profile', ['doctor' => $user]);
})->name('doctor.show');

Route::get('hash/{word}', function(string $word){
    return Hash::make($word);
})->name('doctor.follow');

Route::get('/download-requirements', function(){
    return \Illuminate\Support\Facades\Storage::disk('public')->download('doctor-registration-steps.txt');
})->name('download.requirements');

Route::get('/download/doctor-doc/{user}', function(User $user){
    return \Illuminate\Support\Facades\Storage::disk('public')
        ->download($user->getAttribute('document_path'));
})->name('download-doctor-document');


require __DIR__.'/auth.php';
