<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Models\Role;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    use ApiResponse;

    public function register(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $customer = Role::where('slug', 'customer')->first();

        $user->roles()->attach($customer);

        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken,
        ]);


    }

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

                    $user = User::find(Auth::user()->id)->first();
                    $token = $user->createToken('API Token')->plainTextToken;

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Login successful',
                        'user' => $user,
                        'token' => $token,
                    ]);

                    // return response()->json([
                    //     'status' => 200,
                    //     'message' => ' Non User',
                    // ]);
                }
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Wrong credentials',
                ]);
            }

        }

    }

    public function createAdmin()
    {

        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@gmail.com';
        $user->password = bcrypt('1111');
        $user->save();

        $admin = Role::where('slug', 'admin')->first();

        $user->roles()->attach($admin);

    }

    public function userShow()
    {

        $user = User::where('id', Auth::user()->id)->first();

        return $this->success([
            'status' => 'success',
            'message' => 'User details fetched successfully',
            'user' => $user,
        ]);

    }

    public function updateUser(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        }

        User::updateOrCreate(
            ['id' => Auth::user()->id],
            [
                'name' => $request->name,
                // 'email' => $request->email,
                // 'phone' => $request->phone,
                // 'address' => $request->address,
                // 'twitter_link' => $request->twitter_link,
                // 'fb_link' => $request->fb_link,
                // 'insta_link' => $request->insta_link,
                // 'github_link' => $request->github_link,
                // 'portfolio_link' => $request->portfolio_link,
            ]
        );

        return $this->success([
            'status' => 'success',
            'message' => 'User details updated successfully',
            'user' => User::where('id', Auth::user()->id)->first(),
        ]);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success([
            'status' => 'success',
            'message' => 'Logged out successfully',
        ]);
    }

}
