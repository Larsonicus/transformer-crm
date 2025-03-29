<?php

namespace App\Helpers;

use App\Enums\TaskStatus;

class TaskHelper
{
    public function readableStatus($status) {
        return match ($status) {
            TaskStatus::PENDING => 'В ожидании',
            TaskStatus::IN_PROGRESS => 'В процессе',
            TaskStatus::COMPLETED => 'Завершенные',
        };
    }
}
