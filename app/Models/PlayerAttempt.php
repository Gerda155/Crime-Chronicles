<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerAttempt extends Model
{
    use HasFactory;

    protected $fillable = ['player_id', 'case_id', 'chosen_suspect_id', 'is_correct'];
}
