<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attempt;
use Carbon\Carbon;
use Exam;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    function resultList()
    {
        $data = Attempt::where('user_id', Auth::user()->id)->whereNot('status', 'reject')->get();
        $attempt = $data->map(function ($data) {

            $data['model_name'] = $data->model->title;
            // $data['time_take'] =  Carbon::parse($data->start_quiz)->diffInMinutes(Carbon::parse($data->end_quiz));
            $data['questions'] = $data->model->questions->count();
            $data['date'] = $data->created_at->format('g:iA - d M y');
            $data['exam_time'] = $data->model->exam_time;
            $data['status'] = ($data->status == 'result' || $data->status == 'done') ? true : false; // Loading for 1 : See For 2


            unset($data['model']);
            unset($data['model_id']);
            unset($data['user_id']);
            unset($data['admin_notification']);
            unset($data['start_quiz']);
            unset($data['end_quiz']);
            unset($data['user_notification']);
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
            $history = Exam::GetResultCount($id);


            return response()->json([
                'status'    => 1,
                'history'   => $history,
                'data'      => $data,
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Result not published',
            ]);
        }
    }

    function downloadPDF($id)
    {
        $question = Exam::TotalResultList($id);
        $history = Exam::GetResultCount($id);
        $model = Attempt::find($id);
        $name = 'result-' . $model->created_at . '.pdf';

        $pdf = PDF::loadView('pdf.result', [
            'questions' => $question,
            'history' => $history,
            'model' => $model,
        ]);

        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $name, $headers);
    }
}
