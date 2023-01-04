<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'expiry_date'
    ];

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class,'exam_id');
    }
}
