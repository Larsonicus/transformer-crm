<?php
namespace App\Livewire\Request;

use Livewire\Component;
use App\Models\ClientRequest;

class Show extends Component
{
    public ClientRequest $request;

    public function render()
    {
        return view('livewire.request.show', [
            'request' => $this->request->load(['user', 'partner', 'source'])
        ]);
    }
}
