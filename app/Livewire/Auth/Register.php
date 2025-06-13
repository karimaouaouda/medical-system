<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    use WithFileUploads;
    public string $name = '';

    public string $email = '';

    public string $role = UserRole::Patient->value;

    public $document;

    public string $password = '';

    public string $password_confirmation = '';

    public function mount(string $role = UserRole::Patient->value): void
    {
        $this->role = $role;
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', new Enum(UserRole::class)],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'document' => [$this->role === UserRole::Doctor->value ? 'required' : 'nullable', 'file'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        if (isset($validated['document'])) {
            $validated['document_path'] = $validated['document']->store('documents', 'public');
            unset($validated['document']);
        }

        event(new Registered(($user = User::create($validated))));

        if ($user->role === UserRole::Doctor) {
            $user->approved_at = null;
            $user->save();
        }

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}
