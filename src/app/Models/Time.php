<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'attendance',
        'stamped_at'
    ];

    public function user()
    {
        return $this->belongTo(User::class);
    }
}
