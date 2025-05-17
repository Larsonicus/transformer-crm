<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_requests';
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'partner_id',
        'source_id',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}
