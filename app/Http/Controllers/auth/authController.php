<?php

namespace App\Http\Controllers\auth;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class authController extends Controller
{

    public function loginUser(Request $request)
    {

        $validation = Validator::make($request->all(), [

            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string'

        ]);

        // Email not present in DB
        if ($validation->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validation->errors()->first(),
            ]);
        } else {
            $cred = array('email' => $request->email, 'password' => $request->password);

            // Right credentials
            if (Auth::attempt($cred, false)) {
                if (Auth::User()->hasRole('admin')) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Login successful',
                    ]);
                } else {
                    return response()->json([
                        'status' => 200,
                        'message' => ' Non User',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Wrong credentials',
                ]);
            }

        }

    }

}