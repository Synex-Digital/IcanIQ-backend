<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionChoice;
use Illuminate\Http\Request;

class GetAnswerController extends Controller
{
    function getanswer(Request $request){
        // echo $request->question_id;
        $opt = $opt='<option value="">Select A Answer</option>';
        $questionchoices = QuestionChoice::where('question_id', $request->question_id)->get();
        foreach ($questionchoices as $key => $questionchoice) {
            $opt .= '<option value="'.$questionchoice->id.'">'.$questionchoice->choice_text.'</option>';
        }
        echo $opt;
    }
}
