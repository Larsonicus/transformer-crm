<?php

namespace App\Livewire\Source;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Source;

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
        Source::find($id)->delete();
        session()->flash('success', 'Источник удалён');
    }

    public function render()
    {
        $sources = Source::when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.source.index', compact('sources'));
    }
}
