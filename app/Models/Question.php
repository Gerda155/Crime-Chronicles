<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }
}
