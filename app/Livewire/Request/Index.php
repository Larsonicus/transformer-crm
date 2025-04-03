<?php

namespace App\Livewire\Request;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ClientRequest;

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
        ClientRequest::find($id)->delete();
        session()->flash('success', 'Заявка удалена');
    }

    public function render()
    {
        $requests = ClientRequest::with(['user', 'partner', 'source'])
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.request.index', compact('requests'));
    }
}
