<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

use Exam;


class TestController extends Controller
{
    public function show(Request $request, string $id)
    {
        $data       = Exam::TotalResultList($id);
        $history    = Exam::GetResultCount($id);

        if ($request->has('filter') && $request->filter != null) {
            if ($request->filter == 'true') {
                $data = array_filter($data, function ($item) {
                    return $item['is_correct'] == true;
                });
            } elseif ($request->filter == 'false') {
                $data = array_filter($data, function ($item) {
                    return $item['is_correct'] == false;
                });
            }
        }

        return view('backend.test.index', [
            'id' => $id,
            'questions' => $data,
            'history' => $history,
        ]);
    }

    function download($id)
    {
        $question   = Exam::TotalResultList($id);
        $history    = Exam::GetResultCount($id);
        $model      = Attempt::find($id);
        $name       = 'result-' . $model->created_at . '.pdf';

        $pdf = PDF::loadView('pdf.result', [
            'questions' => $question,
            'history' => $history,
            'model' => $model,
        ]);

        // dd($history);
        return $pdf->download($name);
    }
}
