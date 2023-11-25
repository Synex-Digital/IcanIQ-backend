<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = ClassModel::all();
        $requests = Student::all();
        return view('backend.student.index', compact('classes', 'requests'));
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
        $validated = $request->validate([
            'name' => 'required|max:255',
            'number' => 'required|min:11|numeric',
            'profile' => 'required',
            'password' => 'required|min:8',
        ]);
        $image = $request->profile;
        $image_name = $request->name.rand(1000,10).'.'.$image->extension();
        Image::make($image)->save(base_path('public/files/student/' . $image_name));
        Student::insert([
            'class_id' => $request->class_id,
            'name' => $request->name,
            'number' => $request->number,
            'password' => bcrypt($request->password),
            'profile' => $image_name,
            'status' => $request->status,
            'created_at' =>Carbon::now(),
        ]);
        return back()->with('succ', 'Student Added...');
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
        $student = Student::find($id);
        return $student;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'number' => 'required|min:11|numeric',
        ]);
        $student = Student::where('id', $request->id)->first();
        if ($request->profile) {
            $old_image = $student->profile;
            $old_image_path = base_path('public/files/student/' . $old_image);
            unlink($old_image_path);
            $image = $request->profile;
            $image_name = $request->name.rand(1000,10).'.'.$image->extension();
            Image::make($image)->save(base_path('public/files/student/' . $image_name));
        }
        else{
            $image_name = $student->profile;
        }
        Student::where('id', $request->id)->update([
            'class_id' => $request->class_id,
            'name' => $request->name,
            'number' => $request->number,
            'password' => bcrypt($request->password),
            'profile' => $image_name,
            'status' => $request->status,
            'created_at' =>Carbon::now(),
        ]);
        return back()->with('succ', 'Student Updated...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id)->first();
        $old_image = $student->profile;
            $old_image_path = base_path('public/files/student/' . $old_image);
            unlink($old_image_path);
            ClassModel::find($id)->delete();
        return back()->with('succ', 'Student Deleted...');
    }
}
