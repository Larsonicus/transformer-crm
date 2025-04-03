<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ClientRequest;

class Requests extends Component
{
    public function render()
    {
        return view('livewire.requests.index', [
            'requests' => ClientRequest::with(['user', 'partner', 'source'])->latest()->get()
        ]);
    }
}
