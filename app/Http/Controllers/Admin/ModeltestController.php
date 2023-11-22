<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Modeltest;
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
        $requests = Modeltest::all();
        return view('backend.model_test.index', compact('classes', 'requests'));
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
            'title' => 'required|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        Modeltest::insert([
            'class_id' => $request->class_id,
            'title' => $request->title,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'note' => $request->note,
            'status' => $request->status,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('succ', 'Model Test Added...');
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
        $modeltest = Modeltest::find($id);
        return $modeltest;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        $modeltest = Modeltest::where('id', $request->id);
        $modeltest->update([
            'class_id' => $request->class_id,
            'title' => $request->title,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'note' => $request->note,
            'status' => $request->status,
            'updated_at' => Carbon::now(),
        ]);
        return back()->with('succ', 'Model Test Updated...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $modeltest = Modeltest::find($id);
        $modeltest->delete();
        return back()->with('succ', 'Class Deleted...');
    }
}
