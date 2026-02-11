<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlayerAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'case_id',
        'suspect_id',
        'is_correct',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
