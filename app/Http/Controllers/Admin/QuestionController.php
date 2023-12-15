<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Modeltest;
use App\Models\Question;
use App\Models\QuestionChoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $request->validate([
            'question_test' => 'required|max:255',
        ]);
        if ($request->required) {
            $required = true;
        } else {
            $required = false;
        }
        if ($request->status) {
            $status = '1';
        } else {
            $status = '0';
        }

        Question::insert([
            'test_id' => $request->test_id,
            'question_test' => $request->question_test,
            'required' => $required,
            'status' => $status,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('succ', 'Question Added...');
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
        $request->validate([
            'question_test' => 'required|max:255',
        ]);
        if ($request->required) {
            $required = true;
        } else {
            $required = false;
        }
        if ($request->status) {
            $status = '1';
        } else {
            $status = '0';
        }

        Question::where('id', $request->id)->update([
            'test_id' => $request->test_id,
            'question_test' => $request->question_test,
            'required' => $required,
            'status' => $status,
            'updated_at' => Carbon::now(),
        ]);
        return back()->with('succ', 'Question Updated...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        QuestionChoice::find($id)->delete();
        return back()->with('succ', 'Question Deleted...');
    }
}
