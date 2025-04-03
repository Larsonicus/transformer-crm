<?php

namespace App\Livewire\Source;

use Livewire\Component;
use App\Models\Source;

class Edit extends Component
{
    public Source $source;

    protected $rules = [
        'source.name' => 'required|min:3|unique:sources,name,except,id',
    ];

    public function mount(Source $source)
    {
        $this->source = $source;
    }

    public function save()
    {
        $this->validate();

        $this->source->save();

        session()->flash('success', 'Источник обновлён');
        return redirect()->route('sources.index');
    }

    public function render()
    {
        return view('livewire.source.edit');
    }
}
