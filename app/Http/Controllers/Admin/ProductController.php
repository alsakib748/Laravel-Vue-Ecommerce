<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\CategoryAttribute;
use App\Models\ProductAttrImages;
use App\Models\Tax;
use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Traits\SaveFile;
use App\Models\ProductAttr;
use App\Traits\ApiResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use ApiResponse, SaveFile;

    // todo: Product
    public function index()
    {
        $data = Product::get();
        return view('admin.Product.product', get_defined_vars());
    }

    public function view_product(Request $request, $id = 0)
    {
        if ($id == 0) {
            // todo: New Product
            // if ($validation->fails()) {
            //     return $this->error($validation->errors()->first(), 400, []);
            // }

            $data = new Product();
            $product_attr = new ProductAttr();
            $product_attr_images = new ProductAttrImages();
            $category = Category::get();
            $brands = Brand::get();
            $color = Color::get();
            $size = Size::get();
            $tax = Tax::get();
            // prx($data);

        } else {

            $data['id'] = $id;

            // todo: Update Product
            $validation = Validator::make($request->all(), [
                'id' => 'required|exists:products,id',

            ]);

            if ($validation->fails()) {
                return redirect()->back();
            } else {
                $data = Product::where('id', $id)->first();
            }
        }

        return view('admin.Product.manage_product', get_defined_vars());

    }

    public function getAttributes(Request $request)
    {
        $cat = $request->cat;
        $data = CategoryAttribute::with('attribute', 'values')->where('category_id', $cat)->get();

        // dd($data);
        return $this->success($data, 'Select the attribute');
    }

    public function store(Request $request)
    {
        dd($request->all());
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
                $image = Product::find($request->id);
                $imageName = $image->image;
                $imageName = $this->saveImage($request->image, $imageName, 'images/categories');
            } else {
                $imageName = $this->saveImage($request->image, '', 'images/categories');
            }

            if ($request->parent_category_id != null) {
                Product::updateOrCreate(
                    ['id' => $request->id],
                    values: [
                        'name' => $request->name,
                        'slug' => Str::slug($request->slug),
                        'image' => $imageName,
                        'parent_category_id' => $request->parent_category_id
                    ]
                );
            } else {
                Product::updateOrCreate(
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
        $categories = Product::get();
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