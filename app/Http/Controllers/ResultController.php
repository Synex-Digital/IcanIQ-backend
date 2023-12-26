<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use Exam;

class ResultController extends Controller
{
    function result()
    {
        $attempt = Attempt::with('rel_user')->whereNot('status', 'reject')->get();
        foreach ($attempt as  $value) {
            $value['result'] = Exam::GetResultCount($value->id);
        }
        return view('backend.result.index', [
            'attempts'  => $attempt,
        ]);
    }
}
