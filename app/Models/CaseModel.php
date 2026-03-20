<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Genre;
use App\Models\User;

class CaseModel extends Model
{
    use HasFactory;

    protected $table = 'cases';

    protected $fillable = [
        'title',
        'description',
        'preview',
        'genre_id',
        'rating',
        'answer_id',
        'user_id',
        'statuss',
        'solution_explanation',
        'type', 
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evidence()
    {
        return $this->hasMany(Evidence::class, 'case_id');
    }

    public function suspects()
    {
        return $this->hasMany(Suspect::class, 'case_id');
    }

    
    public function attempts()
    {
        return $this->hasMany(PlayerAttempt::class);
    }

    public function completedCases()
    {
        return $this->belongsToMany(CaseModel::class, 'player_attempts')
                    ->wherePivot('is_correct', true);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'achievement_user');
    }
}
