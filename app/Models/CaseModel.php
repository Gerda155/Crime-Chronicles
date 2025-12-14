<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Genre;

class CaseModel extends Model
{
    use HasFactory;

    protected $table = 'cases';

    protected $fillable = [
        'title', 'description', 'preview', 'genre_id', 'rating', 'answer'
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
