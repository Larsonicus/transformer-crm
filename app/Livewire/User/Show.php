<?php
namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;

class Show extends Component
{
    public User $user;

    public function render()
    {
        return view('livewire.user.show');
    }
}
