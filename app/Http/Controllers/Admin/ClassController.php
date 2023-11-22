<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Return_;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = ClassModel::all();
        return view('backend.class.index', compact('requests'));
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
            'name' => 'required|max:255',
        ]);
        ClassModel::insert([
            'admin_id' => Auth::guard('admin')->user()->id,
            'class_name' => $request->name,
            'status' => $request->status,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('succ', 'Class Added...');
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
        $class = ClassModel::find($id);
        return $class;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);
        $class = ClassModel::where('id', $request->id);
        $class->update([
            'class_name' => $request->name,
            'status' => $request->status,
            'updated_at' => Carbon::now(),
        ]);
        return back()->with('succ', 'Class Updated...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $class = ClassModel::find($id);
        $class->delete();
        return back()->with('succ', 'Class Deleted...');
    }
}
