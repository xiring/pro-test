<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'question'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id');
    }

    public function answers()
    {
        return $this->hasMany(QuestionAnswer::class,'question_id');
    }
}
