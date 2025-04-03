<?php
namespace App\Livewire\Partner;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Partner;

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
        Partner::find($id)->delete();
        session()->flash('success', 'Партнёр удалён');
    }

    public function render()
    {
        $partners = Partner::when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")
            ->orWhere('contact_email', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.partner.index', compact('partners'));
    }
}
