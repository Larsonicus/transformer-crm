<?php
namespace App\Livewire\Request;

use Livewire\Component;
use App\Models\ClientRequest;
use App\Models\User;
use App\Models\Partner;
use App\Models\Source;

class Create extends Component
{
    public $title;
    public $description;
    public $user_id;
    public $partner_id;
    public $source_id;
    public $status = 'new';

    protected $rules = [
        'title' => 'required|min:5',
        'description' => 'required|min:10',
        'user_id' => 'required|exists:users,id',
        'partner_id' => 'required|exists:partners,id',
        'source_id' => 'required|exists:sources,id',
        'status' => 'required|in:new,in_progress,completed'
    ];

    public function save()
    {
        $this->validate();

        ClientRequest::create([
            'title' => $this->title,
            'description' => $this->description,
            'user_id' => $this->user_id,
            'partner_id' => $this->partner_id,
            'source_id' => $this->source_id,
            'status' => $this->status
        ]);

        session()->flash('success', 'Заявка успешно создана');
        return redirect()->route('requests.index');
    }

    public function render()
    {
        return view('livewire.request.create', [
            'users' => User::all(),
            'partners' => Partner::all(),
            'sources' => Source::all()
        ]);
    }
}
