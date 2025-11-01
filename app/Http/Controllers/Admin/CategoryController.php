<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Attribute;
use App\Models\CategoryAttribute;
use App\Traits\ApiResponse;
use App\Traits\SaveFile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    use ApiResponse, SaveFile;

    // todo: Category
    public function index()
    {
        // dd("working");
        $data = Category::get();
        // $attributes = Attribute::get();
        return view('admin.Category.category', get_defined_vars());
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validation = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif'
            ]
        );

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {

            if ($request->id > 0) {
                $image = Category::find($request->id);
                $imageName = $image->image;
                $imageName = $this->saveImage($request->image, $imageName, 'images/categories');
            } else {
                $imageName = $this->saveImage($request->image, '', 'images/categories');
            }

            if ($request->parent_category_id != null) {
                Category::updateOrCreate(
                    ['id' => $request->id],
                    values: [
                        'name' => $request->name,
                        'slug' => Str::slug($request->slug),
                        'image' => $imageName,
                        'parent_category_id' => $request->parent_category_id
                    ]
                );
            } else {
                Category::updateOrCreate(
                    ['id' => $request->id],
                    values: [
                        'name' => $request->name,
                        'slug' => Str::slug($request->slug),
                        'image' => $imageName
                    ]
                );
            }

            return $this->success(['reload' => true], 'Category Successfully updated');

        }
    }

    public function index_category_attribute()
    {
        // dd("working");
        $data = CategoryAttribute::with(['category', 'attribute'])->get();
        $attributes = Attribute::get();
        $categories = Category::get();
        return view('admin.Category.category_attribute', get_defined_vars());
    }

    public function store_category_attribute(Request $request)
    {
        // dd($request->all());
        $validation = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'attribute_id' => 'required|exists:attributes,id',
                'category_id' => 'required|exists:categories,id',
            ]
        );

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {

            CategoryAttribute::updateOrCreate(
                ['id' => $request->id],
                [
                    'attribute_id' => $request->attribute_id,
                    'category_id' => $request->category_id,
                ]
            );

            return $this->success(['reload' => true], 'Category Attribute Successfully updated');
        }
    }
}
