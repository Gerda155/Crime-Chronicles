<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Achievement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'icon',
        'required_cases',
        'status',
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }


}
