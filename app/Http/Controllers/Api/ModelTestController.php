<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

                $attempt = Attempt::where('user_id', Auth::user()->id)->where('model_id', $data->id)->first(); //getting attempt data

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
        if (Auth::check()) {
            if (Modeltest::find($id)) {
                $time = Carbon::now()->subHour(2);
                $model = Attempt::where('model_id', $id)
                    ->where('created_at', '>=', $time)
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
                    'message'   => 'Model not found'
                ], 206);
            }
        } else { //Login Check
            return response()->json([
                'status'    => 0,
                'message'   => 'User Not Authorized'
            ], 401);
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
            $update->start_quiz = Carbon::now();
            $update->save();

            $questionsUpdate = Question::with('choices')->where('test_id', $request->model_id)->where('status', 1)->get();
            $questions = $questionsUpdate->map(function ($data) {
                unset($data['test_id']);
                unset($data['required']);
                unset($data['status']);
                unset($data['created_at']);
                unset($data['updated_at']);

                $questions = $data->choices->map(function ($data) {
                    unset($data['is_correct']);
                    unset($data['question_id']);
                    unset($data['created_at']);
                    unset($data['updated_at']);
                    return $data;
                });

                // //Adding extra data
                $data['question_test_image'] = $data['question_test_image'] != null ? asset('files/question/' . $data['question_test_image']) : null;
                return $data;
            });
            return response()->json([
                'status'    => 1,
                'data'      => $questions
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Someting is wrong with your Model Request, please contact with authority',
            ]);
        }
    }
}
