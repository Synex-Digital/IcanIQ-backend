<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    function admin_register(){
        $admin = Admin::count();
        if ($admin != 0) {
            return redirect()->route('admin.login');
        } else {
            return view('backend.layouts.admin_register');
        }
    }
    function admin_login(){
        return view('backend.layouts.admin_login');
    }
    function admin_store(Request $request){
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'number' => 'required|min:11|numeric',
            'profile' => 'required',
            'password' => 'required|min:8',
        ]);
        $image = $request->profile;
        $image_name = $request->name.rand(1000,10).'.'.$image->extension();
        Image::make($image)->save(base_path('public/files/profile/' . $image_name));
        Admin::insert([
            'name' => $request->name,
            'profile' => $image_name,
            'email' => $request->email,
            'number' => $request->number,
            'status' => $request->status,
            'password' => bcrypt($request->password),
            'created_at' =>Carbon::now(),
        ]);
        $credentials =  $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()
                ->route('dashboard')
                ->with('Welcome! Your account has been successfully created!');
        }
    }

    function dashboard(){
        return 'dashboard';
    }
}
