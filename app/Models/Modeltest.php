<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modeltest extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
    public function questions()
    {
        return $this->hasMany(Question::class, 'test_id');
    }
    public function attempt()
    {
        return $this->hasMany(Attempt::class, 'model_id');
    }
}
