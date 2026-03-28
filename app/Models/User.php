<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\PlayerAttempt;
use App\Models\Achievement;
use App\Models\CaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'avatar',
        'status',
        'role',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    public function attempts()
    {
        return $this->hasMany(PlayerAttempt::class);
    }

    public function achievements()
    {
        return $this->belongsToMany(
            Achievement::class,
            'achievement_user',
            'user_id',
            'achievement_id'
        );
    }

    public function completedCases()
    {
        return $this->belongsToMany(
            CaseModel::class,
            'player_attempts',
            'user_id',
            'case_id'
        )->wherePivot('is_correct', 1);
    }
}

