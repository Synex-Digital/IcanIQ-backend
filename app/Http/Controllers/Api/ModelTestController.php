<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attempt;
use App\Models\Modeltest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
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

                if ($attempt->status == 'accept') {
                    $status = 2;
                } elseif ($attempt->status == 'reject') {
                    $status = 3;
                } else {
                    $status = 1;
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
    // function approvalModel(): JsonResponse
    // {
    //     if (Auth::check()) {
    //         $modelTest = Attempt::where('user_id', Auth::user()->id)->get();

    //         $model = $modelTest->map(function ($data) {
    //             unset($data['start_quiz']);
    //             unset($data['end_quiz']);
    //             unset($data['admin_notification']);
    //             unset($data['updated_at']);
    //             return $data;
    //         });

    //         if ($modelTest->count() != 0) {
    //             return response()->json([
    //                 'status'    => 1,
    //                 'total'     => $modelTest->count(),
    //                 'data'      => $model,
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status'    => 0,
    //                 'message'   => 'Data not found'
    //             ], 200);
    //         }
    //     } else {
    //         return response()->json([
    //             'status'    => 0,
    //             'message'   => 'User Not Authorized'
    //         ], 401);
    //     }
    // }
}
