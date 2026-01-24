<?php

namespace App\Http\Controllers\Front;

use App\Models\CategoryAttribute;
use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Models\HomeBanner;
use App\Models\ProductAttr;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{

    use ApiResponse;

    public function getHomeData()
    {

        $data = [];

        $data['banner'] = HomeBanner::get();

        $data['categories'] = Category::with('products:id,category_id,name,slug,image,item_code')->get();

        $data['brands'] = Brand::get();

        return $this->success(
            ['data' => $data],
            'Home Page Data Fetched Successfully'
        );

    }

    public function getHeaderCategoriesData()
    {
        $data['categories'] = Category::with('subCategories')->where('parent_category_id', null)->get();

        // dd($data);

        return $this->success(
            ['data' => $data],
            'Categories Data Fetched Successfully'
        );
    }

    public function getCategoryData(Request $request)
    {

        $attribute = $request->attribute;
        $brand = $request->brand;
        $color = $request->color;
        $size = $request->size;
        $highPrice = $request->highPrice;
        $lowPrice = $request->lowPrice;
        $slug = $request->slug;

        \Log::info('getCategoryData called with slug: ' . $slug);

        $category = Category::where('slug', $slug)->first();

        \Log::info('Category found: ' . ($category ? $category->name : 'None') . ' with ID: ' . ($category ? $category->id : 'None'));

        if (isset($category->id)) {

            // $products = Product::with(['productAttributes'])->select('id', 'name', 'slug', 'image', 'item_code')->where('category_id', $category->id)->paginate(10);

            // \Log::info('Products found for category ' . $category->name . ': ' . $products->count());

            // $data = Category::with('products:id,category_id,name,slug,image,item_code')->where('slug', $slug)->first();

            $products = $this->getFilterProducts($category->id, $size, $color, $brand, $attribute, $lowPrice, $highPrice);


            if (!$category) {
                return $this->error('Category not found', 404);
            }

            if ($category->parent_category_id == Null || $category->parent_category_id == '') {
                // parent cat
                // $cat = Category::where('parent_category_id', $data->id)->get();
                $cat = Category::whereNull('parent_category_id')->get();
            } else {
                // child cat
                $cat = Category::where('parent_category_id', $category->parent_category_id)->where('id', '!=', $category->id)->get();
            }

        } else {
            $category = Category::first();

            $products = Product::with(['productAttributes'])->select('id', 'name', 'slug', 'image', 'item_code')->where('category_id', $category->id)->paginate(10);

            // $data = Category::with('products:id,category_id,name,slug,image,item_code')->where('slug', $slug)->first();

            if (!$category) {
                return $this->error('Category not found', 404);
            }

            if ($category->parent_category_id == Null || $category->parent_category_id == '') {
                // parent cat
                // $cat = Category::where('parent_category_id', $data->id)->get();
                $cat = Category::whereNull('parent_category_id')->get();
            } else {
                // child cat
                $cat = Category::where('parent_category_id', $category->parent_category_id)->where('id', '!=', $category->id)->get();
            }

        }

        $lowPrice = ProductAttr::orderBy('price', 'asc')->pluck('price')->first();

        $highPrice = ProductAttr::orderBy('price', 'desc')->pluck('price')->first();

        $brands = Brand::orderBy('id', 'asc')->get();

        $colors = Color::orderBy('id', 'asc')->get();

        $sizes = Size::orderBy('id', 'asc')->get();

        $attributes = CategoryAttribute::where('category_id', $category->id)->with('attribute')->get();

        return $this->success(
            ['data' => get_defined_vars()],
            'Category Page Data Fetched Successfully'
        );

    }

    public function getFilterProducts($category_id, $size, $color, $brand, $attribute, $lowPrice, $highPrice)
    {

        $products = Product::where('category_id', $category_id);

        if (sizeof($brand) > 0) {
            $products = $products->whereIn('brand_id', $brand);
        }

        if (sizeof($attribute) > 0) {
            $products = $products->withWhereHas('attribute', function ($q) use ($attribute) {
                $q->whereIn('attribute_value_id', $attribute);
            });
        }

        if (sizeof($size) > 0) {
            $products = $products->withWhereHas('productAttributes', function ($q) use ($size) {
                $q->whereIn('size_id', $size);
            });
        }

        if (sizeof($color) > 0) {
            $products = $products->withWhereHas('productAttributes', function ($q) use ($color) {
                $q->whereIn('color_id', $color);
            });
        }

        if ($lowPrice != '' && $lowPrice != null && $highPrice != '') {
            $products = $products->withWhereHas('productAttributes', function ($q) use ($lowPrice, $highPrice) {
                $q->whereBetween('price', [$lowPrice, $highPrice]);
            });
        }

        $products = $products->with(['productAttributes'])->select('id', 'name', 'slug', 'image', 'item_code')->paginate(10);

        return $products;

    }

    public function changeSlug()
    {
        $data = Product::get();

        foreach ($data as $list) {
            $result = Product::find($list->id);

            $result->slug = replaceStr($result->name);

            $result->save();
        }
    }

}
