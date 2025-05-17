<?php

namespace App\Services\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

interface RequestServiceInterface
{
    /**
     * Get paginated requests with relations
     */
    public function getPaginatedRequests(string $search = '', int $perPage = 10): LengthAwarePaginator;

    /**
     * Delete request by ID
     */
    public function deleteRequest(int $id): bool;

    /**
     * Import requests from Excel file
     */
    public function importFromExcel(UploadedFile $file): void;

    /**
     * Export requests to Excel file
     */
    public function exportToExcel(): string;
} 