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
            $data = new Product();
            $product_attr = collect(); // Empty collection for new product
            $product_attr_images = collect(); // Empty collection for new product
            $product_attributes = collect(); // Empty collection for new product
            $category = Category::get();
            $brands = Brand::get();
            $color = Color::get();
            $size = Size::get();
            $tax = Tax::get();

        } else {
            // todo: Update Product
            // Validate the route parameter directly
            $validation = Validator::make(['id' => $id], [
                'id' => 'required|integer|exists:products,id',
            ]);

            if ($validation->fails()) {
                return redirect()->route('product.index')->with('error', 'Invalid product ID');
            }

            $data = Product::where('id', $id)->first();

            if (!$data) {
                return redirect()->route('product.index')->with('error', 'Product not found');
            }

            // Load existing product attributes (color, size, sku, etc.)
            $product_attr = ProductAttr::where('product_id', $id)->get();

            // Load existing product attribute images grouped by product_attr_id
            $product_attr_images = ProductAttrImages::where('product_id', $id)->get()->groupBy('product_attr_id');

            // Load existing category-based product attributes
            $product_attributes = ProductAttribute::where('product_id', $id)->pluck('attribute_value_id')->toArray();

            // Load dropdown options
            $category = Category::get();
            $brands = Brand::get();
            $color = Color::get();
            $size = Size::get();
            $tax = Tax::get();
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
        // Debug: Check if description is being received
        // Uncomment the line below to see what's being sent
        // \Log::info('Description received: ' . ($request->input('description') ?? 'NULL'));
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
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }

        try {
            $isUpdate = $request->id > 0;

            // Handle deletion of specific images (from existing images removal UI)
            if ($request->has('deleted_images') && !empty($request->deleted_images)) {
                $deletedImageIds = explode(',', $request->deleted_images);
                foreach ($deletedImageIds as $imageId) {
                    $imageId = trim($imageId);
                    if (!empty($imageId)) {
                        $image = ProductAttrImages::find($imageId);
                        if ($image) {
                            // Delete the file if it exists
                            if (file_exists(public_path($image->image))) {
                                unlink(public_path($image->image));
                            }
                            // Delete the database record
                            $image->delete();
                        }
                    }
                }
            }

            // Save or update product
            if ($isUpdate) {
                // Update existing product
                $product = Product::find($request->id);
                if (!$product) {
                    return redirect()->back()->with('error', 'Product not found');
                }

                // Handle image update
                $imageName = $product->image;
                if ($request->hasFile('image')) {
                    $imageName = $this->saveImage($request->image, $imageName, 'images/products');
                }

                // Update product fields
                $product->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->slug),
                    'image' => $imageName,
                    'item_code' => $request->item_code ?? null,
                    'keywords' => $request->keywords ?? null,
                    'category_id' => $request->category_id ?? null,
                    'brand_id' => $request->brand_id ?? null,
                    'tax_id' => $request->tax_id ?? null,
                    'description' => $request->input('description'),
                ]);
            } else {
                // Create new product
                $imageName = null;
                if ($request->hasFile('image')) {
                    $imageName = $this->saveImage($request->image, '', 'images/products');
                }

                $product = Product::create([
                    'name' => $request->name,
                    'slug' => Str::slug($request->slug),
                    'image' => $imageName,
                    'item_code' => $request->item_code ?? null,
                    'keywords' => $request->keywords ?? null,
                    'category_id' => $request->category_id ?? null,
                    'brand_id' => $request->brand_id ?? null,
                    'tax_id' => $request->tax_id ?? null,
                    'description' => $request->input('description'),
                ]);
            }

            // Process category-based product attributes
            if ($request->has('attribute_id') && is_array($request->attribute_id) && !empty($request->attribute_id)) {
                // Delete existing product attributes if updating
                if ($isUpdate) {
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
                // If no attributes provided and updating, delete existing ones
                if ($isUpdate) {
                    ProductAttribute::where('product_id', $product->id)->delete();
                }
            }

            // Process product attributes
            if ($request->has('color') && is_array($request->color) && !empty($request->color)) {
                // Get existing attributes and their images if updating
                $existingAttrs = collect();
                $existingImagesMap = [];
                if ($isUpdate) {
                    $existingAttrs = ProductAttr::where('product_id', $product->id)->get();
                    // Create a map of existing images by attribute ID
                    foreach ($existingAttrs as $attr) {
                        $existingImagesMap[$attr->id] = ProductAttrImages::where('product_attr_id', $attr->id)->get();
                    }
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

                // Track which existing attributes are being used
                $usedExistingAttrIds = [];

                // Loop through each attribute in the form
                foreach ($colors as $index => $colorId) {
                    $sizeId = $sizes[$index] ?? null;
                    $sku = $skus[$index] ?? null;

                    // Try to find matching existing attribute by color, size, and sku
                    $matchedAttr = null;
                    if ($isUpdate && $existingAttrs->isNotEmpty()) {
                        $matchedAttr = $existingAttrs->first(function ($attr) use ($colorId, $sizeId, $sku) {
                            return $attr->color_id == $colorId &&
                                $attr->size_id == $sizeId &&
                                $attr->sku == $sku;
                        });
                    }

                    if ($matchedAttr && !in_array($matchedAttr->id, $usedExistingAttrIds)) {
                        // Update existing attribute - this preserves the ID and existing images
                        $matchedAttr->update([
                            'color_id' => $colorId,
                            'size_id' => $sizeId,
                            'sku' => $sku,
                            'mrp' => $mrps[$index] ?? 0,
                            'price' => $prices[$index] ?? 0,
                            'qty' => $request->qty[$index] ?? 0,
                            'length' => $lengths[$index] ?? '0',
                            'breadth' => $breadths[$index] ?? '0',
                            'height' => $heights[$index] ?? '0',
                            'weight' => $weights[$index] ?? '0',
                        ]);
                        $productAttr = $matchedAttr;
                        $usedExistingAttrIds[] = $matchedAttr->id;
                    } else {
                        // Create new product attribute
                        $productAttr = ProductAttr::create([
                            'product_id' => $product->id,
                            'color_id' => $colorId,
                            'size_id' => $sizeId,
                            'sku' => $sku,
                            'mrp' => $mrps[$index] ?? 0,
                            'price' => $prices[$index] ?? 0,
                            'qty' => $request->qty[$index] ?? 0,
                            'length' => $lengths[$index] ?? '0',
                            'breadth' => $breadths[$index] ?? '0',
                            'height' => $heights[$index] ?? '0',
                            'weight' => $weights[$index] ?? '0',
                        ]);
                    }

                    // Process NEW images for this specific attribute
                    // Existing images are automatically preserved when we update the attribute
                    if (isset($attrImages[$index]) && is_array($attrImages[$index])) {
                        foreach ($attrImages[$index] as $imageFile) {
                            if ($imageFile && $imageFile->isValid()) {
                                $imageName = $this->saveImage($imageFile, '', 'images/product_attributes');

                                // Store the new image associated with this attribute
                                ProductAttrImages::create([
                                    'product_id' => $product->id,
                                    'product_attr_id' => $productAttr->id,
                                    'image' => $imageName,
                                ]);
                            }
                        }
                    }
                }

                // Delete attributes (and their images) that are no longer in the form
                if ($isUpdate && $existingAttrs->isNotEmpty()) {
                    $attrsToDelete = $existingAttrs->whereNotIn('id', $usedExistingAttrIds);
                    foreach ($attrsToDelete as $attrToDelete) {
                        // Delete images first
                        ProductAttrImages::where('product_attr_id', $attrToDelete->id)->delete();
                        // Then delete the attribute
                        $attrToDelete->delete();
                    }
                }
            } else {
                // If no attributes provided and updating, delete existing ones
                if ($isUpdate) {
                    ProductAttrImages::where('product_id', $product->id)->delete();
                    ProductAttr::where('product_id', $product->id)->delete();
                }
            }

            // Redirect to product list page
            try {
                return redirect()->route('product.index')
                    ->with('success', 'Product ' . ($isUpdate ? 'updated' : 'created') . ' successfully');
            } catch (\Exception $redirectException) {
                // Fallback to URL if route fails
                \Log::error('Redirect error: ' . $redirectException->getMessage());
                return redirect('/admin/product')
                    ->with('success', 'Product ' . ($isUpdate ? 'updated' : 'created') . ' successfully');
            }

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Product save error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Error saving product: ' . $e->getMessage())
                ->withInput();
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