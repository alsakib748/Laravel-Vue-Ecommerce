<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Traits\SaveFile;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{

    use ApiResponse, SaveFile;

    public function index()
    {
        // dd("working");
        $data = Brand::get();
        return view('admin.Brand.brand', get_defined_vars());
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,avif,webp,gif'
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400);
        }

        $brand = $request->id > 0 ? Brand::findOrFail($request->id) : new Brand;

        // ─── ONLY SAVE IMAGE IF A FILE WAS UPLOADED ─────────────────────
        $imageName = $brand->image ?? ''; // keep old image

        if ($request->hasFile('image')) {
            $imageName = $this->saveImage(
                $request->file('image'),
                $imageName,
                'images/brands'
            );
        }
        // ────────────────────────────────────────────────────────────────

        $brand->name = $request->name;
        $brand->image = $imageName;
        $brand->save();

        return $this->success(['reload' => true], 'Brand saved successfully');
    }

}