<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\MailMarketing;
use App\Models\Question;
use App\Models\QuestionChoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class QuestionChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::all();
        $requests = QuestionChoice::all();
        return view('backend.question_choice.index', compact('questions', 'requests'));
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
        $data = [
            'name' => 'Synex Digital',
            'link' => 'https://synexdigital.com',
        ];
        Mail::to('email@gmail.com')->send(new MailMarketing($data, 'Synex Digital'));
        return back();
        die();
        dd($request->all());
        $request->validate([
            'choice_text' => 'required|max:255',
        ]);
        if ($request->is_correct) {
            $is_correct = true;
        } else {
            $is_correct = false;
        }
        $question_choice_count = QuestionChoice::where('question_id', $request->question_id)->count();
        $question_correct_count = QuestionChoice::where('question_id', $request->question_id)->where('is_correct', 1)->count();
        if ($question_choice_count < 4) {
            if ($question_correct_count == 1 && $is_correct) {
                return back();
            }
            QuestionChoice::insert([
                'question_id' => $request->question_id,
                'choice_text' => $request->choice_text,
                'is_correct' => $is_correct,
                'created_at' => Carbon::now(),
            ]);
            return back()->with('succ', 'Answered Option Added...');
        }
        return back()->with('err', 'You can set four option only.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $question  = Question::find($id);
        $questions = Question::all();
        $requests = QuestionChoice::where('question_id', $id)->get();
        return view('backend.question_choice.index', compact('questions', 'requests', 'question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $modeltest = QuestionChoice::find($id);
        return $modeltest;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'choice_text' => 'required|max:255',
        ]);
        if ($request->is_correct) {
            $is_correct = true;
        } else {
            $is_correct = false;
        }
        QuestionChoice::where('id', $request->id)->update([
            'question_id' => $request->question_id,
            'choice_text' => $request->choice_text,
            'is_correct' => $is_correct,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('succ', 'Answered Option Added...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
