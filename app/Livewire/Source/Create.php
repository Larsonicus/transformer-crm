<?php

namespace App\Livewire\Source;

use Livewire\Component;
use App\Models\Source;

class Create extends Component
{
    public $name;

    protected $rules = [
        'name' => 'required|min:3|unique:sources',
    ];

    public function save()
    {
        $this->validate();

        Source::create([
            'name' => $this->name,
        ]);

        session()->flash('success', 'Источник успешно создан');
        return redirect()->route('sources.index');
    }

    public function render()
    {
        return view('livewire.source.create');
    }
}
