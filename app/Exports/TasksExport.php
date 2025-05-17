<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Database\Eloquent\Builder;

class TasksExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $query;

    public function __construct($query = null)
    {
        $this->query = $query instanceof Builder ? $query : Task::query();
    }

    public function collection()
    {
        return $this->query->with(['assignedUser', 'partner'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Название',
            'Описание',
            'Статус',
            'Порядок',
            'Срок выполнения',
            'Исполнитель',
            'Партнер',
            'Создано',
            'Обновлено'
        ];
    }

    public function map($task): array
    {
        return [
            $task->id,
            $task->title,
            $task->description,
            $task->status->value === 'pending' ? 'В ожидании' : 
                ($task->status->value === 'in_progress' ? 'В работе' : 'Завершено'),
            $task->order,
            $task->due_date ? $task->due_date->format('d.m.Y') : '',
            $task->assignedUser ? $task->assignedUser->name : '',
            $task->partner ? $task->partner->name : '',
            $task->created_at->format('d.m.Y H:i'),
            $task->updated_at->format('d.m.Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ]
            ],
        ];
    }
} 