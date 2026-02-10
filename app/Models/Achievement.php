<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Achievement extends Model
{
    use HasFactory;

        protected $fillable = [
        'title',
        'description',
        'icon',
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'user_achievements'
        )->withTimestamps();
    }
}
