<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'contact_email', 'phone'];

    public function requests()
    {
        return $this->hasMany(Request::class);
    }
}
