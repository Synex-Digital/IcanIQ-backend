<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Modeltest;
use App\Models\Question;
use App\Models\QuestionChoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Photo;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = Question::all();
        $modeltests = Modeltest::all();
        return view('backend.question.index', compact('requests', 'modeltests'));
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

        if($request->question_test_text != null || $request->question_test_image != null){
            $image_name = null;
            if($request->question_test_image != null){
                Photo::upload($request->question_test_image, 'files/question', 'Question', ['500', '500']);
                $image_name = Photo::$name;
            }
            Question::insert([
                'test_id' => $request->test_id,
                'question_test_text' => $request->question_test_text,
                'question_test_image' => $image_name,
                'created_at' => Carbon::now(),
            ]);
            return back()->with('succ', 'Question Added...');
        }
        else{
            return back()->with('err', 'Question Added...');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $question = Question::find($id);
        return $question;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        dd($request->all());
    if($request->question_test_text != null || $request->question_test_image != null){
        if ($request->status) {
            $status = '1';
        } else {
            $status = '0';
        }
        $image_name = null;
        if($request->question_test_image != null){
            Photo::upload($request->question_test_image, 'files/question', 'Question', ['500', '500']);
            $image_name = Photo::$name;
        }
        Question::where('id', $request->id)->update([
            'test_id' => $request->test_id,
            'question_test_text' => $request->question_test_text,
            'question_test_image' => $image_name,
            'status' => $status,
            'updated_at' => Carbon::now(),
        ]);
        return back()->with('succ', 'Question Updated...');
    }
    else{
        return back()->with('err', 'Question Updated...');
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Questionimg = Question::find($id);
        if ($Questionimg->question_test_image != null) {
            Photo::delete('files/question/', $Questionimg->question_test_image);
        }
        Question::find($id)->delete();
        return back()->with('succ', 'Question Deleted...');

    }
}
