<?php

namespace App\Livewire\Doctor;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Index extends Component
{

    public function query(){
        return User::query()->where('role', 'doctor')->paginate(10);
    }


    public function render()
    {

        return view('livewire.doctor.index', [
            'doctors' => $this->query()
        ]);
    }
}
