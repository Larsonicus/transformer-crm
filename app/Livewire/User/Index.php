<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10]
    ];

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('success', 'Пользователь удален');
    }

    public function render()
    {
        $users = User::when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")
            ->orWhere('email', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.user.index', compact('users'));
    }
}
