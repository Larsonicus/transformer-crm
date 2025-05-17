<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CallQuestionnaire extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'call_script_id',
        'title',
        'is_active',
        'questions'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'questions' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function callScript()
    {
        return $this->belongsTo(CallScript::class);
    }

    public function responses()
    {
        return $this->hasMany(CallResponse::class);
    }
} 