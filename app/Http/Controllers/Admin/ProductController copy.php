<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tax;
use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Traits\SaveFile;
use App\Models\Attribute;
use App\Models\ProductAttr;
use App\Traits\ApiResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Models\CategoryAttribute;
use App\Models\ProductAttrImages;
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

        // dd($request->all());

        $validation = Validator::make(
            $request->all(),
            [
                'id' => 'nullable|integer',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif',
                'category_id' => 'nullable|exists:categories,id',
                'brand_id' => 'nullable|exists:brands,id',
                'tax_id' => 'nullable|exists:taxes,id',
                'color' => 'required|array',
                'color.*' => 'required|exists:colors,id',
                'size' => 'required|array',
                'size.*' => 'required|exists:sizes,id',
                'attr_image' => 'nullable|array',
                'attr_image.*' => 'nullable|array',
                'attr_image.*.*' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif',
                'attribute_id' => 'nullable|array',
                'attribute_id.*' => 'nullable|exists:attribute_values,id'
            ]
        );

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        }

        try {
            // Save or update product
            if ($request->id > 0) {
                $product = Product::find($request->id);
                if (!$product) {
                    return $this->error('Product not found', 404, []);
                }
                $imageName = $product->image;
                if ($request->hasFile('image')) {
                    $imageName = $this->saveImage($request->image, $imageName, 'images/products');
                }
            } else {
                $imageName = null;
                if ($request->hasFile('image')) {
                    $imageName = $this->saveImage($request->image, '', 'images/products');
                }
            }

            $product = Product::updateOrCreate(
                ['id' => $request->id ?? 0],
                [
                    'name' => $request->name,
                    'slug' => Str::slug($request->slug),
                    'image' => $imageName,
                    'item_code' => $request->item_code ?? null,
                    'keywords' => $request->keywords ?? null,
                    'category_id' => $request->category_id ?? null,
                    'brand_id' => $request->brand_id ?? null,
                    'tax_id' => $request->tax_id ?? null,
                    'description' => $request->mytextarea ?? null,
                ]
            );

            // Process category-based product attributes
            if ($request->has('attribute_id') && is_array($request->attribute_id) && !empty($request->attribute_id)) {
                // Delete existing product attributes if updating
                if ($request->id > 0) {
                    ProductAttribute::where('product_id', $product->id)->delete();
                }

                // Get category_id from product
                $categoryId = $product->category_id;

                if ($categoryId) {
                    foreach ($request->attribute_id as $attributeValueId) {
                        if ($attributeValueId) {
                            ProductAttribute::create([
                                'category_id' => $categoryId,
                                'product_id' => $product->id,
                                'attribute_value_id' => $attributeValueId,
                            ]);
                        }
                    }
                }

            } else {
                if ($request->id > 0) {
                    ProductAttribute::where('product_id', $product->id)->delete();
                }
            }

            // Process product attributes
            if ($request->has('color') && is_array($request->color)) {
                // Delete existing attributes if updating
                if ($request->id > 0) {
                    ProductAttr::where('product_id', $product->id)->delete();
                    ProductAttrImages::where('product_id', $product->id)->delete();
                }

                $colors = $request->color;
                $sizes = $request->size ?? [];
                $skus = $request->sku ?? [];
                $mrps = $request->mrp ?? [];
                $prices = $request->price ?? [];
                $lengths = $request->length ?? [];
                $breadths = $request->breadth ?? [];
                $heights = $request->height ?? [];
                $weights = $request->weight ?? [];
                $attrImages = $request->attr_image ?? [];

                // Loop through each attribute
                foreach ($colors as $index => $colorId) {
                    // Create product attribute
                    $productAttr = ProductAttr::create([
                        'product_id' => $product->id,
                        'color_id' => $colorId,
                        'size_id' => $sizes[$index] ?? null,
                        'sku' => $skus[$index] ?? null,
                        'mrp' => $mrps[$index] ?? 0,
                        'price' => $prices[$index] ?? 0,
                        'qty' => 0, // You may want to add this field to the form
                        'length' => $lengths[$index] ?? '0',
                        'breadth' => $breadths[$index] ?? '0',
                        'height' => $heights[$index] ?? '0',
                        'weight' => $weights[$index] ?? '0',
                    ]);

                    // Process images for this specific attribute
                    if (isset($attrImages[$index]) && is_array($attrImages[$index])) {
                        foreach ($attrImages[$index] as $imageFile) {
                            if ($imageFile && $imageFile->isValid()) {
                                $imageName = $this->saveImage($imageFile, '', 'images/product_attributes');

                                // Store the image associated with this attribute
                                ProductAttrImages::create([
                                    'product_id' => $product->id,
                                    'product_attr_id' => $productAttr->id,
                                    'image' => $imageName,
                                ]);
                            }
                        }
                    }
                }
            }

            // return $this->success(['reload' => true], 'Product Successfully saved');
            return redirect()->route('product.index')->with('success', 'Product Successfully saved');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error saving product: ' . $e->getMessage());
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
