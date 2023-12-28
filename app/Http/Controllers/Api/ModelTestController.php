<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Banner;
use App\Models\Modeltest;
use App\Models\Question;
use Carbon\Carbon;
use Exam;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModelTestController extends Controller
{
    function model(): JsonResponse
    {
        $modelTest = Modeltest::where('status', 1)->get();
        foreach ($modelTest as $key => $data) {
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
                } elseif ($attempt->status == 'result') {
                    $status = 4; //Completed button
                } elseif ($attempt->status == 'reject') {
                    $status = 5; //Reject button
                } else {
                    $status = 1; //Request button
                }
            } else {
                $status = 1;
            }

            //Adding extra data
            $data['approval'] = $status;
            $data['index'] = $key + 1;
            $data['total_question'] = $data->questions ? $data->questions->count() : 0;
        }


        // $model = $modelTest->map(function ($data) {
        //     unset($data['status']);
        //     unset($data['updated_at']);

        //     //functions
        //     $status = null;

        //     if (Attempt::where('user_id', Auth::user()->id)->where('model_id', $data->id)->exists()) {

        //         $attempt = Attempt::where('user_id', Auth::user()->id)->where('model_id', $data->id)->latest()->first(); //getting attempt data

        //         if ($attempt->status == 'pending') {
        //             $status = 2; //Pending button
        //         } elseif ($attempt->status == 'accept') {
        //             $status = 3; //Start button
        //         } elseif ($attempt->status == 'result') {
        //             $status = 4; //Completed button
        //         } elseif ($attempt->status == 'reject') {
        //             $status = 5; //Reject button
        //         } else {
        //             $status = 1; //Request button
        //         }
        //     } else {
        //         $status = 1;
        //     }

        //     //Adding extra data
        //     $data['approval'] = $status;
        //     return $data;
        // });
        return response()->json([
            'status' => 1,
            'total' => $modelTest->count(),
            'modelTest' => $modelTest,
        ], 200);
    }

    function request($id): JsonResponse
    {

        if (Modeltest::find($id)) {
            // $time = Carbon::now()->subHour(2);
            $model = Attempt::where('user_id', Auth::user()->id)->where('model_id', $id)
                ->whereIn('status', ['pending', 'accept', 'result'])
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
                    'message'   => 'Please wait for the next Attempt'
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

            $examTime = 0;

            if ($update && $update->end_quiz == null) {
                $minute = $update->model->exam_time;
                $update->start_quiz = Carbon::now();
                $update->end_quiz = Carbon::now()->addMinutes($minute);
                $update->save();
            } else {
            }
            $currentTime = Carbon::now();
            $examTime = $currentTime->diffInSeconds($update->end_quiz);

            if ($currentTime->gt($update->end_quiz)) {
                $examTime = 0;
            }


            $questionsUpdate = Question::with('choices')->where('test_id', $request->model_id)->where('status', 1)->get();
            $questions = $questionsUpdate->map(function ($data, $index) {
                // unset($data['test_id']);
                unset($data['required']);
                // unset($data['status']);
                unset($data['created_at']);
                unset($data['updated_at']);


                //Adding extra data
                $data['question_test_image'] = $data['question_test_image'] != null ? asset('files/question/' . $data['question_test_image']) : null;

                $attemptID = Attempt::where('model_id', $data->test_id)->where('status', 'accept')->first()->id;

                $answer = Answer::where('attempt_id', $attemptID)->where('student_id', Auth::user()->id)->where('question_id', $data->id)->first();
                $question = $answer ? true : false;

                $data['exam_status'] = $question;
                $data['index'] = $index + 1;

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

    function performance(): JsonResponse
    {
        if (Auth::check()) {
            $data = Exam::avarageInfo(Auth::user()->id);
            $banner = Banner::all();
            foreach ($banner as $key => $value) {
                $value['banner'] = asset('files/banner/' . $value->banner);
            }

            if ($data) {
                return response()->json([
                    'status' => 1,
                    'banner'   => $banner,
                    'data'   => $data,
                ]);
            }
            return response()->json([
                'status' => 0,
                'message'   => 'Contact with authority',
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message'   => 'Contact with authority',
            ]);
        }
    }
}
