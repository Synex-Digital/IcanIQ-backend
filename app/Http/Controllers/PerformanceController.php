<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use App\Models\Modeltest;
use Exam;
use Illuminate\Support\Facades\Auth;

class PerformanceController extends Controller
{
    function list()
    {
        //need User ID
        $data = Exam::GetResultCount(1);
        $attempt = Attempt::select('id')->where('user_id', 1)->whereIn('status', ['result', 'done'])->get();

        $totalTest = $attempt->count();

        $avScore = null;
        $avTime = null;

        foreach ($attempt as $key => $value) {
            $data = Exam::GetResultCount($value->id);
            $value['x'] = $data;
            $avScore += $data['correct'];
            // $avTime += $data['time_taken'];
        }

        $score = $avScore / $totalTest; //avarage score
        dd($attempt);


        $model = Modeltest::where('status', 1)->get();
        foreach ($model as  $value) {
            $attempt = Attempt::where('model_id', $value->id)->where('status', 'result')->get();
            $value['count'] = $attempt->count();
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
}
