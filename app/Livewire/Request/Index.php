<?php

namespace App\Livewire\Request;

use App\Services\Contracts\RequestServiceInterface;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    private RequestServiceInterface $requestService;

    public $excelFile;
    public $search = '';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10]
    ];

    public function mount(RequestServiceInterface $requestService)
    {
        $this->requestService = $requestService;
    }

    public function delete($id)
    {
        if ($this->requestService->deleteRequest($id)) {
            session()->flash('success', 'Заявка удалена');
        } else {
            session()->flash('error', 'Не удалось удалить заявку');
        }
    }

    public function importRequest()
    {
        try {
            $this->requestService->importFromExcel($this->excelFile);
            session()->flash('success', 'Данные успешно импортированы');
        } catch (\Exception $e) {
            session()->flash('error', 'Ошибка при импорте данных: ' . $e->getMessage());
        }

        $this->excelFile = null;
    }

    public function exportRequest()
    {
        try {
            return response()->download(
                $this->requestService->exportToExcel(),
                'requests.xlsx'
            );
        } catch (\Exception $e) {
            session()->flash('error', 'Ошибка при экспорте данных: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $requests = $this->requestService->getPaginatedRequests(
            search: $this->search,
            perPage: $this->perPage
        );

        return view('livewire.request.index', compact('requests'));
    }
}
