<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Modeltest;

class ModelTestController extends Controller
{
    function model()
    {
        $modelTest = Modeltest::where('status', 1)->get();
        return response()->json([
            'status' => 1,
            'total' => $modelTest->count(),
            'modelTest' => $modelTest,
        ], 200);
    }
}
