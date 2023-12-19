<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Attempt;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

class AnswerController extends Controller
{
    function submit(Request $request): JsonResponse
    { //Submitting answer
        $validator = Validator::make($request->all(), [
            'model_id'          => 'required',
            'question_id'       => 'required',
            'choice_id'         => 'required',
        ]);

        if ($validator->fails()) { //validation fails message
            return response()->json([
                'status'    => 0,
                'message'   => $validator->errors()->messages(),
            ], 400);
        }

        if (Attempt::where('user_id', Auth::user()->id)->where('model_id', $request->model_id)->where('status', 'accept')->exists()) {

            $answer = null;
            if (Answer::where('student_id', Auth::user()->id)->where('question_id', $request->question_id)->exists()) {
                $answer = Answer::where('student_id', Auth::user()->id)->where('question_id', $request->question_id)->first();
            } else {

                $answer = new Answer();
                $answer->student_id     = Auth::user()->id;
            }
            $answer->question_id    = $request->question_id;
            $answer->choice_id      = $request->choice_id;
            $answer->save();

            $attempt = Attempt::where('user_id', Auth::user()->id)->where('model_id', $request->model_id)->where('status', 'accept')->first();
            // $attempt->status    = 'result';
            $attempt->end_quiz  = Carbon::now();
            $attempt->save();


            return response()->json([
                'status'    => 1,
                'data'      => $answer,
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Model test not found, contact with autority',
            ]);
        }
    }

    function done(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'model_id'          => 'required',
        ]);

        if ($validator->fails()) { //validation fails message
            return response()->json([
                'status'    => 0,
                'message'   => $validator->errors()->messages(),
            ], 400);
        }

        if (Attempt::where('user_id', Auth::user()->id)->where('model_id', $request->model_id)->where('status', 'accept')->exists()) {
            // $answer = null;
            // if (Answer::where('student_id', Auth::user()->id)->where('question_id', $request->question_id)->exists()) {
            //     $answer = Answer::where('student_id', Auth::user()->id)->where('question_id', $request->question_id)->first();
            // } else {

            //     $answer = new Answer();
            //     $answer->student_id     = Auth::user()->id;
            // }
            // $answer->question_id    = $request->question_id;
            // $answer->choice_id      = $request->choice_id;
            // $answer->save();

            $attempt = Attempt::where('user_id', Auth::user()->id)->where('model_id', $request->model_id)->where('status', 'accept')->first();
            $attempt->status    = 'result';
            $attempt->end_quiz  = Carbon::now();
            $attempt->save();


            return response()->json([
                'status'    => 1,
                'data'      => 'Done',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Model test not found, contact with autority',
            ]);
        }
    }
}
