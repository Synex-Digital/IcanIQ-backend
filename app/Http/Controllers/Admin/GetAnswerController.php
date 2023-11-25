<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionChoice;
use Illuminate\Http\Request;

class GetAnswerController extends Controller
{
    function getanswer($id){
        $questionchoices = QuestionChoice::where('question_id', $id)->get();
        return $questionchoices;
    }
}
