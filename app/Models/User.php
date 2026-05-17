<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function attempts()
    {
        return $this->hasMany(PlayerAttempt::class);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'achievement_user');
    }

    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }

    public function createdCases()
    {
        return $this->hasMany(CaseModel::class, 'user_id');
    }

    public function getTotalScoreAttribute()
    {
        return $this->progress()->sum('score');
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

    public function getErrorCountAttribute()
    {
        return $this->attempts()
            ->where('is_correct', 0)
            ->count();
    }

    public function getTotalAttemptsCountAttribute()
    {
        return $this->attempts()
            ->distinct('case_id')
            ->count('case_id');
    }

    public function getSuccessRateAttribute()
    {
        $total = $this->total_attempts_count;
        if ($total === 0) return 0;

        return round(($this->completed_cases_count / $total) * 100, 1);
    }

    public function getCreatedCasesCountAttribute()
    {
        return $this->createdCases()->count();
    }

    public function getRangAttribute()
    {
        $score = $this->total_score;

        return Rang::where('status', 'active')
            ->where('min_score', '<=', $score)
            ->where(function ($q) use ($score) {
                $q->whereNull('max_score')
                    ->orWhere('max_score', '>=', $score);
            })
            ->first();
    }

    public function getRangNameAttribute()
    {
        return $this->rang?->name ?? 'Bez ranga';
    }

    public function hasRatedCase($caseId)
    {
        return $this->ratings()
            ->where('case_id', $caseId)
            ->exists();
    }

    public function ratings()
    {
        return $this->hasMany(\App\Models\Rating::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class)
            ->latest();
    }
}
