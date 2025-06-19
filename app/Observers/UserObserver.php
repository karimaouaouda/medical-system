<?php

namespace App\Observers;

use App\Enums\UserRole;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {

        // Send a notification to the admin when a new user is created
        $admin = User::where('role', 'admin')->first(); // Assuming admin users have a specific role
        if ($admin) {
            if( $user->getAttribute('role')->value == UserRole::Doctor->value ){
                \Filament\Notifications\Notification::make()
                    ->title('New doctor Created')
                    ->body('A new doctor has been registered and waiting for approval: ' . $user->name)
                    ->success()
                    ->sendToDatabase($admin);
            }else{
                \Filament\Notifications\Notification::make()
                    ->title('New Patient Created')
                    ->body('A new Patient has been registered: ' . $user->name)
                    ->success()
                    ->sendToDatabase($admin);
            }
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
