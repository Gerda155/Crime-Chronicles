<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Suspect;

class Question extends Model
{
    protected $fillable = [
        'case_id',
        'suspect_id',
        'question_text',
        'answer_text',
    ];

    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }

    public function suspect()
{
    return $this->belongsTo(Suspect::class);
}
}
