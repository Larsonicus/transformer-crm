<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CallResponse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'call_questionnaire_id',
        'user_id',
        'client_request_id',
        'answers',
        'notes',
        'status'
    ];

    protected $casts = [
        'answers' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function questionnaire()
    {
        return $this->belongsTo(CallQuestionnaire::class, 'call_questionnaire_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clientRequest()
    {
        return $this->belongsTo(ClientRequest::class);
    }
} 