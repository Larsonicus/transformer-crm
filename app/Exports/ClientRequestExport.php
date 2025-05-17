<?php

namespace App\Exports;

use App\Models\ClientRequestImport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientRequestExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ClientRequestImport::all();
    }

    public function headings(): array
    {
        return [];
    }
}
