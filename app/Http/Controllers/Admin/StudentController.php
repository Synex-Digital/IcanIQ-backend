<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Photo;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = ClassModel::all();
        $requests = User::all();
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
            'name'      => 'required|max:255',
            'email'     => 'required|email',
            'number'    => 'required|min:11|numeric',
            'password'  => 'required|min:8',
        ]);

        $image = $request->profile;
        $image_name = null;
        if ($request->has('profile')) {
            Photo::upload($image, 'files/student', 'Student', ['500', '500']);
            $image_name = Photo::$name;
        }

        $id = User::count() == 0 ? User::count() : User::orderBy('id', 'DESC')->first()->id;
        $student_id = Carbon::now()->format('Ydm') . $id;
        User::insert([
            // 'class_id' => $request->class_id,
            'student_id'    => $student_id,
            'name'          => $request->name,
            'email'         => $request->email,
            'number'        => $request->number,
            'profile'       => $image_name,
            'password'      => bcrypt($request->password),
            'created_at'    => Carbon::now(),
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

    public function edit(string $id)
    {
        $student = User::find($id);
        return $student;
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'      => 'required|max:255',
            'email'     => 'required|email',
            'number'    => 'required|min:11|numeric',
        ]);
        $student = User::where('id', $request->id)->first();
        if ($request->has('profile')) {
            if ($student->profile != null) {
                Photo::delete('files/student/', $student->profile);
            }
            $image = $request->profile;
            Photo::upload($image, 'files/student', 'Student', ['500', '500']);
            $image_name = Photo::$name;
        } else {
            $image_name = $student->profile;
        }
        User::where('id', $request->id)->update([
            'name'          => $request->name,
            'email'         => $request->email,
            'number'        => $request->number,
            'password'      => bcrypt($request->password),
            'profile'       => $image_name,
            'status'        => $request->status,
            'created_at'    => Carbon::now(),
        ]);
        return back()->with('succ', 'Student Updated...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($id);
        $student = User::find($id);
        // Photo::upload($request->thumbnail, 'uploads/blog', 'BLOG', ['700', '500']);
        if ($student->profile != null) {
            Photo::delete('files/student/', $student->profile);
        }

        User::find($id)->delete();
        return back()->with('succ', 'Student Deleted...');
    }
}
