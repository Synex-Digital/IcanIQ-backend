<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function PHPSTORM_META\map;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required',
        ]);

        if ($validator->fails()) { //validation fails message
            return response()->json([
                'status'    => 0,
                'message'   => $validator->errors()->messages(),
            ], 400);
        }

        //Loggin attempt
        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->validity !== null) {
                $validityDateString = trim($user->validity);

                // Adjust format to consider date and time (if present)
                $validityDate = Carbon::createFromFormat('Y-m-d H:i:s', $validityDateString);

                if ($validityDate !== false && $validityDate->isPast()) {
                    return response()->json([
                        'status' => 0,
                        'user' => 'User validation expired',
                    ], 200);
                }
            }

            $profile = $user->profile != null ? asset('files/student/' . $user->profile) : null;
            $user->profile = $profile;
            $user->date = $validityDate->format('d M y');

            $token = $user->createToken('userlogin')->accessToken;

            return response()->json([
                'status'    => 1,
                'token'     => $token,
                'user'      => $user,
            ], 200);
        } else {
            return response()->json([
                'status'    => 0,
                'user'      => 'Not Found',
            ], 200);
        }
        // Auth::attempt($credentials);

    }


    public function logout(): JsonResponse
    {
        $user = Auth::user();

        if ($user) {
            $user->token()->revoke(); // Revoking the user's access token

            return response()->json(['message' => 'Successfully logged out'], 200);
        }

        return response()->json(['message' => 'Unable to logout'], 400);
    }

    function test()
    {
        $data = User::all();
        return response()->json(['data' => $data]);
    }
}
