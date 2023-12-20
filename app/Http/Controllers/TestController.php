<?php

namespace App\Http\Controllers;

use App\Models\Modeltest;
use App\Models\Question;
use App\Models\QuestionChoice;
use Illuminate\Http\Request;
use PDF;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $models = Modeltest::where('id', $id)->get();
        $questions = Question::with('choices')->where('test_id', $id)->get();
        return view('backend.test.index', [
            'questions'=>$questions,
            'models'=>$models,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    function download_invoice($id){
        // $models = Modeltest::where('id', $id)->get();
        // $questions = Question::with('choices')->where('test_id', $id)->get();
        // $invoice = PDF::loadView('backend.test.invoice', [
        //     'questions'=>$questions,
        //     'models'=>$models,
        // ]);
        // return $invoice->download('result.pdf');
        $models = Modeltest::where('id', $id)->get();
        $questions = Question::with('choices')->where('test_id', $id)->get();
        return view('backend.test.invoice', [
            'questions'=>$questions,
            'models'=>$models,
        ]);
    }
}
