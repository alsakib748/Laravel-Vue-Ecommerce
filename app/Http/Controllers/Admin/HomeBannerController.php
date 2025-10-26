<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomeBanner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;

class HomeBannerController extends Controller
{

    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd("working");

        $data = HomeBanner::get();
        return view('admin.HomeBanner.home_banners', get_defined_vars());
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

        // dd($request->all());

        $validation = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'text' => 'required|string|max:255',
                'link' => 'required|string',
                'image' => 'required|image|mimes:png,jpg,jpeg,avif,webp,gif'
            ]
        );

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            if ($request->hasFile('image')) {
                if ($request->id > 0) {
                    $image = HomeBanner::where('id', $request->id)->first();
                    // $image_path = "images/" . $image->image . "";
                    $image_path = $image->image;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
                $image_name = 'images/' . uniqid() . '.' . $request->image->extension();
                $request->image->move(public_path('images/'), $image_name);

            } elseif ($request->id > 0) {
                $image_name = HomeBanner::where('id', $request->id)->pluck('image')->first();
            }

            HomeBanner::updateOrCreate(
                ['id' => $request->id],
                [
                    'text' => $request->text,
                    'link' => $request->link,
                    'image' => $image_name,
                ]
            );

            return $this->success(['reload' => true], 'Home Banner Successfully updated');

        }

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}