<?php

namespace App\Livewire\Source;

use Livewire\Component;
use App\Models\Source;

class Show extends Component
{
    public Source $source;

    public function render()
    {
        return view('livewire.source.show');
    }
}
