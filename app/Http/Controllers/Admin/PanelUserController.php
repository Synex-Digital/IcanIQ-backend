<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Photo;

class PanelUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $panelusers = Admin::all();
        return view('backend.panel_users.index', [
            'panelusers' => $panelusers,
        ]);
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
            'name'      => 'required|max:255',
            'email'     => 'required|email',
            'number'    => 'required|min:11|numeric',
            'password'  => 'required|min:8',
        ]);

        $image = $request->profile;
        $image_name = null;
        if ($request->has('profile')) {
            Photo::upload($image, 'files/panelusers', 'panelusers', ['500', '500']);
            $image_name = Photo::$name;
        }

        Admin::insert([
            'name'          => $request->name,
            'email'         => $request->email,
            'number'        => $request->number,
            'profile'       => $image_name,
            'password'      => bcrypt($request->password),
            'role'          => $request->role,
            'created_at'    => Carbon::now(),
        ]);
        return back()->with('succ', 'Panel Users Added...');
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
        $panelusers = Admin::find($id);
        return $panelusers;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'      => 'required|max:255',
            'email'     => 'required|email',
            'number'    => 'required|min:11|numeric',
        ]);
        $panelusers = Admin::where('id', $request->id)->first();
        if ($request->has('profile')) {
            if ($panelusers->profile != null) {
                Photo::delete('files/panelusers/', $panelusers->profile);
            }
            $image = $request->profile;
            Photo::upload($image, 'files/panelusers', 'panelusers', ['500', '500']);
            $image_name = Photo::$name;
        } else {
            $image_name = $panelusers->profile;
        }
        Admin::where('id', $request->id)->update([
            'name'          => $request->name,
            'email'         => $request->email,
            'number'        => $request->number,
            'profile'       => $image_name,
            'password'      => bcrypt($request->password),
            'role'          => $request->role,
            'status'        => $request->status,
            'created_at'    => Carbon::now(),
        ]);
        return back()->with('succ', 'Panel Users Updated...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $panelusers = Admin::find($id);
        if ($panelusers->profile != null) {
            Photo::delete('files/panelusers/', $panelusers->profile);
        }

        Admin::find($id)->delete();
        return back()->with('succ', 'Panel Users Deleted...');
    }
}
