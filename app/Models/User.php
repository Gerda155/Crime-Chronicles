<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Achievement;
use App\Models\CaseModel;
use App\Models\PlayerAttempt;
use App\Models\Rang;
use App\Models\UserProgress;

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

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

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

    public function ratings()
    {
        return $this->hasMany(\App\Models\Rating::class);
    }

    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }

    /*
    |--------------------------------------------------------------------------
    | CALCULATED VALUES
    |--------------------------------------------------------------------------
    */


    public function getTotalScoreAttribute()
    {
        return $this->progress()->sum('score');
    }

    // Аксессор для ранга - это позволит использовать $user->rang
    public function getRangAttribute()
    {
        $totalScore = $this->total_score;

        // Находим подходящий ранг на основе общего счета
        return Rang::where('status', 'active')
            ->where('min_score', '<=', $totalScore)
            ->where(function ($query) use ($totalScore) {
                $query->whereNull('max_score')
                    ->orWhere('max_score', '>=', $totalScore);
            })
            ->first();
    }

    // Для отладки - получить ранг и прогресс до следующего
    public function getRangProgressAttribute()
    {
        $rang = $this->rang;  // Теперь используем аксессор
        if (!$rang) return null;

        $totalScore = $this->total_score;

        // Ищем следующий ранг
        $nextRang = Rang::where('status', 'active')
            ->where('min_score', '>', $totalScore)
            ->orderBy('min_score', 'asc')
            ->first();

        if (!$nextRang) {
            return [
                'current' => $rang,
                'next' => null,
                'current_score' => $totalScore,
                'next_min' => null,
                'progress' => 100
            ];
        }

        $progress = ($totalScore - $rang->min_score) / ($nextRang->min_score - $rang->min_score) * 100;
        $progress = min(100, max(0, $progress));

        return [
            'current' => $rang,
            'next' => $nextRang,
            'current_score' => $totalScore,
            'next_min' => $nextRang->min_score,
            'progress' => round($progress)
        ];
    }

    // Вспомогательный метод для отображения названия ранга
    public function getRangNameAttribute()
    {
        $rang = $this->rang;
        return $rang ? $rang->name : 'Bez ranga';
    }

    // Метод для отладки - посмотреть общий счет
    public function getDebugScoreAttribute()
    {
        return $this->total_score;
    }
    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function hasRatedCase($caseId)
    {
        return $this->ratings()
            ->where('case_id', $caseId)
            ->exists();
    }
}
