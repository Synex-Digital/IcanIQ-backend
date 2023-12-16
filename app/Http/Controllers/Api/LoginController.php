<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required',
        ]);

        if ($validator->fails()) { //validation fails message
            return response([
                'status'    => 0,
                'message'   => $validator->messages(),
            ], 400);
        }

        //Loggin attempt
        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $user->createToken('userlogin')->accessToken;
            return response([
                'status'    => 1,
                'token'     => $token,
                'user'      => $user,
            ], 200);
        } else {
            return response([
                'status'    => 0,
                'user'      => 'Not Found',
            ], 200);
        }
        // Auth::attempt($credentials);

    }
    function data()
    {
        return response()->json([
            'status' => 1
        ]);
    }
}
