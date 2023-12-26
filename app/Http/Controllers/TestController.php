<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use Barryvdh\DomPDF\Facade\Pdf;

use Exam;


class TestController extends Controller
{
    public function show(string $id)
    {

        $data       = Exam::TotalResultList($id);
        $history    = Exam::GetResultCount($id);


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
