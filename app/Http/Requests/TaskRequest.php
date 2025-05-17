<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:' . implode(',', TaskStatus::values()),
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'partner_id' => 'nullable|exists:partners,id',
        ];
    }
} 