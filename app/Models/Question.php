<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['test_id', 'question_test_text','question_test_image', 'required', 'status'];

    function modeltest()
    {
        return $this->belongsTo(Modeltest::class, 'test_id');
    }

    public function choices()
    {
        return $this->hasMany(QuestionChoice::class, 'question_id');
    }
}
