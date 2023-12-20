<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Modeltest;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModelTestController extends Controller
{
    function model(): JsonResponse
    {
        $modelTest = Modeltest::where('status', 1)->get();
        $model = $modelTest->map(function ($data) {
            unset($data['status']);
            unset($data['updated_at']);

            //functions
            $status = null;

            if (Attempt::where('user_id', Auth::user()->id)->where('model_id', $data->id)->exists()) {

                $attempt = Attempt::where('user_id', Auth::user()->id)->where('model_id', $data->id)->latest()->first(); //getting attempt data

                if ($attempt->status == 'pending') {
                    $status = 2; //Pending button
                } elseif ($attempt->status == 'accept') {
                    $status = 3; //Start button
                } else {
                    $status = 1; //Request button
                }
            } else {
                $status = 1;
            }

            //Adding extra data
            $data['approval'] = $status;
            return $data;
        });
        return response()->json([
            'status' => 1,
            'total' => $modelTest->count(),
            'modelTest' => $model,
        ], 200);
    }

    function request($id): JsonResponse
    {

        if (Modeltest::find($id)) {
            $time = Carbon::now()->subHour(2);
            $model = Attempt::where('model_id', $id)
                ->whereIn('status', ['pending', 'accept'])
                ->get();

            if ($model->count() == 0) {

                $attempt = new Attempt();
                $attempt->user_id               = Auth::user()->id;
                $attempt->model_id              = $id;
                $attempt->status                = 'pending';
                $attempt->admin_notification    =  1;
                $attempt->save();

                return response()->json([
                    'status'    => 1,
                    'message'   => 'Request is pending, wait for the approval'
                ], 200);
            } else { //Multiple Request Check
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Can not attempt twice a day'
                ], 206);
            }
        } else { // Model Check
            return response()->json([
                'status'    => 0,
                'message'   => 'Model not found, contact with authority'
            ], 206);
        }
    }

    function attempt(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'model_id'      => 'required',
        ]);

        if ($validator->fails()) { //validation fails message
            return response()->json([
                'status'    => 0,
                'message'   => $validator->errors()->messages(),
            ], 400);
        }

        if (Attempt::where('user_id', Auth::user()->id)->where('model_id', $request->model_id)->where('status', 'accept')->exists()) {

            $update = Attempt::where('user_id', Auth::user()->id)->where('model_id', $request->model_id)->where('status', 'accept')->first();

            $examTime = null;

            if ($update && $update->end_quiz == null) {
                $minute = $update->model->exam_time;
                $update->start_quiz = Carbon::now();
                $update->end_quiz = Carbon::now()->addMinutes($minute);
                $update->save();
            } else {
            }
            $currentTime = Carbon::now();
            $examTime = $currentTime->diff($update->end_quiz)->format('%H:%I:%S');

            if ($currentTime->gt($update->end_quiz)) {
                $examTime = '00:00:00';
            }


            $questionsUpdate = Question::with('choices')->where('test_id', $request->model_id)->where('status', 1)->get();
            $questions = $questionsUpdate->map(function ($data) {
                // unset($data['test_id']);
                unset($data['required']);
                // unset($data['status']);
                unset($data['created_at']);
                unset($data['updated_at']);


                // //Adding extra data
                $data['question_test_image'] = $data['question_test_image'] != null ? asset('files/question/' . $data['question_test_image']) : null;

                $attemptID = Attempt::where('model_id', $data->test_id)->where('status', 'accept')->first()->id;

                $answer = Answer::where('attempt_id', $attemptID)->where('question_id', $data->id)->first();
                $question = $answer ? true : false;

                $data['exam_status'] = $question;

                $choices = $data->choices;
                foreach ($choices as &$choice) {
                    unset($choice['is_correct']);
                    unset($choice['created_at']);
                    unset($choice['updated_at']);

                    $choice['exam_status'] = false;

                    // You can set the exam status based on the existence of $answer here
                    if ($answer && $choice['id'] == $answer->choice_id) {
                        $choice['exam_status'] = true;
                    }
                }

                return $data;
            });
            return response()->json([
                'status'        => 1,
                'exam_time'     => $examTime,
                'data'          => $questions
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Someting is wrong with your Model Request, please contact with authority',
            ]);
        }
    }
}
