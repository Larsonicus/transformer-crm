<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Edit extends Component
{
    public User $user;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'user.name' => 'required|min:3',
        'user.email' => 'required|email|unique:users,email,except,id',
        'password' => 'nullable|min:8|confirmed',
    ];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function save()
    {
        $this->validate();

        if ($this->password) {
            $this->user->password = Hash::make($this->password);
        }

        $this->user->save();

        session()->flash('success', 'Пользователь обновлен');
        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.user.edit');
    }
}
