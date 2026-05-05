<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suspect extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_id',
        'name',
        'description',
        'image_path',
    ];

    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }
}
