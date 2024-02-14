<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Modeltest;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ModeltestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = ClassModel::all();
        $requests = Modeltest::whereNot('status', 5)->get();
        return view('backend.model_test.index', compact('classes', 'requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|max:255',
            'hours'     => 'required',
            'minutes'   => 'required',
        ]);


        Modeltest::insert([
            'title'         => $request->title,
            'exam_time'     => ($request->hours * 60) + $request->minutes,
            'note'          => $request->note,
            'created_at'    => Carbon::now(),
        ]);
        return back()->with('succ', 'Model Test Added...');
    }

    public function show(string $id)
    {
        $requests = Question::where('test_id', $id)->get();
        $modeltests = Modeltest::find($id);
        return view('backend.question.index', compact('requests', 'modeltests'));
    }


    public function edit(string $id)
    {
        $modeltest = Modeltest::find($id);
        return $modeltest;
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'hours' => 'required',
            'minutes' => 'required',
        ]);
        $modeltest = Modeltest::where('id', $request->id);
        $modeltest->update([
            'title' => $request->title,
            'exam_time'    => ($request->hours * 60) + $request->minutes,
            'note' => $request->note,
            'status' => $request->status,
            'updated_at' => Carbon::now(),
        ]);
        return back()->with('succ', 'Model Test Updated...');
    }

    public function modeltest_soft_delete(Request $request, string $id)
    {
        Modeltest::find($id)->update([
            'status'=> 5,
        ]);
        return back()->with('succ', 'Class Deleted...');
    }
}
