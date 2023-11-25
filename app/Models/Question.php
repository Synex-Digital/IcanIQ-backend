<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    function modeltest(){
        return $this->belongsTo(Modeltest::class, 'test_id');
    }
}
