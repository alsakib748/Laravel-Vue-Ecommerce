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

    public function getCategoryData($slug = '')
    {

        $category = Category::where('slug', $slug)->first();

        if (isset($category->id)) {

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
