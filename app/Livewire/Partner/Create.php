<?php

namespace App\Livewire\Partner;

use Livewire\Component;
use App\Models\Partner;

class Create extends Component
{
    public $name;
    public $contact_email;
    public $phone;

    protected $rules = [
        'name' => 'required|min:3',
        'contact_email' => 'required|email|unique:partners',
        'phone' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();

        Partner::create([
            'name' => $this->name,
            'contact_email' => $this->contact_email,
            'phone' => $this->phone,
        ]);

        session()->flash('success', 'Партнёр успешно создан');
        return redirect()->route('partners.index');
    }

    public function render()
    {
        return view('livewire.partner.create');
    }
}
