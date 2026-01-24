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

        // Email not present in DB or validation fails
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput($request->only('email'));
        }

        $cred = array('email' => $request->email, 'password' => $request->password);
        $remember = $request->has('remember');

        // Right credentials
        if (Auth::attempt($cred, $remember)) {
            // Auth::attempt() already regenerates session automatically

            if (Auth::User()->hasRole('admin')) {
                return redirect('/admin/dashboard');
            } else {
                Auth::logout();
                return redirect()->back()
                    ->with('error', 'You do not have admin access.');
            }
        } else {
            return redirect()->back()
                ->with('error', 'Wrong credentials. Please try again.')
                ->withInput($request->only('email'));
        }
    }

}