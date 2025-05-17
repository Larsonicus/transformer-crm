<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'order',
        'due_date',
        'assigned_to',
        'partner_id'
    ];

    protected $casts = [
        'status' => TaskStatus::class,
        'due_date' => 'datetime',
    ];

    // Добавим константы для статусов
    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';

    public static function statuses()
    {
        return [
            self::STATUS_PENDING => 'В ожидании',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_COMPLETED => 'Завершено',
        ];
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    protected static function boot()
    {
        parent::boot();

        // When creating a new task, set the order to be the last in its status
        static::creating(function ($task) {
            if (!$task->order) {
                $maxOrder = static::where('status', $task->status)->max('order') ?? 0;
                $task->order = $maxOrder + 1;
            }
        });
    }
}
