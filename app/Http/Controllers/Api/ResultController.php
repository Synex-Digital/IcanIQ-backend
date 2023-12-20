<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Question;
use Carbon\Carbon;
use Exam;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    function resultList()
    {
        $data = Attempt::where('user_id', Auth::user()->id)->get();
        $attempt = $data->map(function ($data) {

            $data['model_name'] = $data->model->title;
            // $data['time_take'] =  Carbon::parse($data->start_quiz)->diffInMinutes(Carbon::parse($data->end_quiz));
            $data['questions'] = $data->model->questions->count();
            $data['exam_time'] = $data->model->exam_time;
            $data['status'] = $data->status == 'result' ? true : false; // Loading for 1 : See For 2


            unset($data['model']);
            unset($data['model_id']);
            unset($data['user_id']);
            unset($data['admin_notification']);
            unset($data['start_quiz']);
            unset($data['end_quiz']);
            unset($data['user_notification']);
            unset($data['created_at']);
            unset($data['updated_at']);

            return $data;
        });
        return response()->json([
            'status' => 1,
            'data'   => $attempt,
        ]);
    }
    function result($id): JsonResponse
    {
        $attempt = Attempt::find($id);
        if ($attempt->status == 'result' || $attempt->status == 'done') {
            $data = Exam::TotalResultList($id);


            return response()->json($data);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Result not published',
            ]);
        }
    }
}
