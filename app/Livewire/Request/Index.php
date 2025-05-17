<?php

namespace App\Livewire\Request;

use App\Exports\ClientRequestExport;
use App\Models\ClientRequest;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\ClientRequestImport;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $excelFile;

    public $search = '';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10]
    ];

    public function delete($id)
    {
        ClientRequest::find($id)->delete();
        session()->flash('success', 'Заявка удалена');
    }

    public function importRequest() {
        Excel::import(new ClientRequestImport, $this->excelFile);

        $this->excelFile = null;
    }

    public function exportRequest()
    {
        return Excel::download(new ClientRequestExport(), 'requests.xlsx');
    }

    public function render()
    {
        $requests = ClientRequest::with(['user', 'partner', 'source'])
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.request.index', compact('requests'));
    }
}
