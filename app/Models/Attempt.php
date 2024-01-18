<?php

namespace App\Models;

use Carbon\Carbon;
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

    // function rel_modelstest()
    // {
    //     return $this->belongsTo(Modeltest::class, 'model_id');
    // }
    function rel_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    function model()
    {
        return $this->belongsTo(Modeltest::class, 'model_id');
    }

    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['end_quiz'])->format('d M Y | h:iA');
    }
}
