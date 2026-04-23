<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    protected $fillable = [
        'user_id',
        'case_id',
        'score',
        'opened_evidence',
        'questions_used',
        'completed',
        'created_at',
        'updated_at',
    ];
}
