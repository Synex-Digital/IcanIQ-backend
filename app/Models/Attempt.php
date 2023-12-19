<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'start_quiz',
        'end_quiz',
    ];

    function model()
    {
        return $this->belongsTo(Modeltest::class, 'model_id');
    }
}
