<?php
namespace App\Livewire\Request;

use Livewire\Component;
use App\Models\ClientRequest;

class Edit extends Create
{
    public ClientRequest $request;

    public function mount(ClientRequest $request)
    {
        $this->request = $request;
        $this->title = $request->title;
        $this->description = $request->description;
        $this->user_id = $request->user_id;
        $this->partner_id = $request->partner_id;
        $this->source_id = $request->source_id;
        $this->status = $request->status;
    }

    public function save()
    {
        $this->validate();

        $this->request->update([
            'title' => $this->title,
            'description' => $this->description,
            'user_id' => $this->user_id,
            'partner_id' => $this->partner_id,
            'source_id' => $this->source_id,
            'status' => $this->status
        ]);

        session()->flash('success', 'Заявка обновлена');
        return redirect()->route('requests.index');
    }
}
