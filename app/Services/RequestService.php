<?php

namespace App\Services;

use App\Exports\ClientRequestExport;
use App\Models\ClientRequest;
use App\Models\ClientRequestImport;
use App\Services\Contracts\RequestServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class RequestService implements RequestServiceInterface
{
    public function __construct(
        private readonly ClientRequest $clientRequest
    ) {}

    public function getPaginatedRequests(string $search = '', int $perPage = 10): LengthAwarePaginator
    {
        return $this->clientRequest
            ->with(['user', 'partner', 'source'])
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->latest()
            ->paginate($perPage);
    }

    public function deleteRequest(int $id): bool
    {
        $request = $this->clientRequest->find($id);
        
        if (!$request) {
            return false;
        }

        return $request->delete();
    }

    public function importFromExcel(UploadedFile $file): void
    {
        Excel::import(new ClientRequestImport, $file);
    }

    public function exportToExcel(): string
    {
        return Excel::download(new ClientRequestExport(), 'requests.xlsx')->getFile()->getPathname();
    }
} 