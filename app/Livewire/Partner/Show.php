<?php

namespace App\Livewire\Partner;

use Livewire\Component;
use App\Models\Partner;

class Show extends Component
{
    public Partner $partner;

    public function render()
    {
        return view('livewire.partner.show');
    }
}
