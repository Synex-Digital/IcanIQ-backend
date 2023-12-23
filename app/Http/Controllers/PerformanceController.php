<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use App\Models\Modeltest;
use Exam;

class PerformanceController extends Controller
{
    function list()
    {
        $model = Modeltest::where('status', 1)->get();

        if ($model->count() != 0) {
            foreach ($model as  $value) {
                $attempt = Attempt::where('model_id', $value->id)->where('status', 'result')->get();
                $value['count'] = $attempt->count();
            }
        }

        return view('backend.performance.index', [
            'models' => $model
        ]);
    }
    function attempt_list($id)
    {
        if (!Modeltest::find($id)->exists()) {
            return back();
        }
        $attempt = Attempt::where('model_id', $id)->where('status', 'result')->get();
        $model = Modeltest::find($id);
        foreach ($attempt as  $value) {
            $value['result'] = Exam::GetResultCount($value->id);
        }



        return view('backend.performance.attempt', [
            'attempts'  => $attempt,
            'model'     => $model,
        ]);
    }
    function attempt_done($id)
    {
        Attempt::where('model_id', $id)->where('status', 'result')->update([
            'status' => 'done'
        ]);

        return back()->with('succ', 'Updated');
    }
}
