<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;

class ProfileController extends Controller
{

    use ApiResponse;

    public function index()
    {
        return view('admin/profile');
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        // print_r($request->all());
        // die;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            'phone' => 'required|numeric|digits:11',
            'address' => 'string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 400, []);
            // return response()->json(['status' => 400, 'message' => $validator->errors()->first()]);
        } else {

            if ($request->hasFile('image')) {
                $image_name = 'images/' . uniqid() . '.' . $request->image->extension();
                $request->image->move(public_path('images/'), $image_name);
            } else {
                $image_name = Auth::user()->image;
            }

            $user = User::updateOrCreate(
                ['id' => Auth::user()->id],
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'image' => $image_name ?? Auth::user()->image,
                    'twitter_link' => $request->twitter_link,
                    'fb_link' => $request->fb_link,
                    'insta_link' => $request->insta_link,
                    'github_link' => $request->github_link,
                    'portfolio_link' => $request->portfolio_link,
                ]
            );

            // return response()->json(['status' => 200, 'message' => 'Successfully updated.']);

            return $this->success([], 'Successfully updated');

        }

    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }


}
