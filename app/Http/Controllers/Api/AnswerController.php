<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ], 200);
        }

        if (Attempt::where('user_id', Auth::user()->id)->where('model_id', $request->model_id)->where('status', 'accept')->exists()) {

            $attempt = Attempt::where('user_id', Auth::user()->id)->where('model_id', $request->model_id)->where('status', 'accept')->first();
            $examTime = null;

            $currentTime = Carbon::now();
            $examTime = $currentTime->diff($attempt->end_quiz)->format('%H:%I:%S');

            if ($currentTime->gt($attempt->end_quiz)) {
                $examTime = null;
            }

            $question = Question::find($request->question_id);
            $currect_choice = $question->correctChoice() == null ? 0 : $question->correctChoice()->id;

            $choice = 0;
            if ($request->choice_id == $currect_choice) {
                $choice = 1;
            }


            if ($examTime != null) {
                $answer = null;
                if (Answer::where('attempt_id', $attempt->id)->where('student_id', Auth::user()->id)->where('question_id', $request->question_id)->exists()) {
                    $answer = Answer::where('attempt_id', $attempt->id)->where('student_id', Auth::user()->id)->where('question_id', $request->question_id)->first();
                } else {
                    $answer = new Answer();
                    $answer->student_id     = Auth::user()->id;
                    $answer->attempt_id     = $attempt->id;
                }
                $answer->question_id    = $request->question_id;
                $answer->choice_id      = $request->choice_id;
                $answer->is_correct     = $choice;
                $answer->save();

                return response()->json([
                    'status'        => 1,
                    'data'          => $answer,
                ]);
            } else {
                return response()->json([
                    'status'        => 0,
                    'message'       => 'Exam time is over',
                ]);
            }
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

            $attempt = Attempt::where('user_id', Auth::user()->id)->where('model_id', $request->model_id)->where('status', 'accept')->first();
            $attempt->status    = 'result';
            $attempt->end_quiz  = Carbon::now();
            $attempt->save();


            return response()->json([
                'status'    => 1,
                'exam_time' => 0,
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
