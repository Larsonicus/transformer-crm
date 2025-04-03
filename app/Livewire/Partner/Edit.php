<?php

namespace App\Livewire\Partner;

use Livewire\Component;
use App\Models\Partner;

class Edit extends Component
{
    public Partner $partner;

    protected $rules = [
        'partner.name' => 'required|min:3',
        'partner.contact_email' => 'required|email|unique:partners,contact_email,except,id',
        'partner.phone' => 'nullable|string',
    ];

    public function mount(Partner $partner)
    {
        $this->partner = $partner;
    }

    public function save()
    {
        $this->validate();

        $this->partner->save();

        session()->flash('success', 'Партнёр обновлён');
        return redirect()->route('partners.index');
    }

    public function render()
    {
        return view('livewire.partner.edit');
    }
}
