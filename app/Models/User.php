<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\PlayerAttempt;
use App\Models\Achievement;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'avatar',
        'statuss',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    public function attempts()
    {
        return $this->hasMany(PlayerAttempt::class);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class);
    }

    public function completedCases()
    {
        return $this->hasMany(PlayerAttempt::class)->where('is_correct', 1);
    }
}
