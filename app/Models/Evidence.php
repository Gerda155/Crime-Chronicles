<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_id',
        'description',
        'type',
        'image_path',
        'key_object_area',
    ];

    protected $casts = [
        'key_object_area' => 'array',
    ];

    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }
}