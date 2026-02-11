<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{
    use HasFactory;

    protected $fillable = ['case_id', 'type', 'content'];

    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }
}
