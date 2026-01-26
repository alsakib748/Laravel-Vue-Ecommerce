<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Models\TempUsers;
use App\Models\HomeBanner;
use App\Models\ProductAttr;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Models\CategoryAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HomePageController extends Controller
{

    use ApiResponse;

    public function getHomeData()
    {

        $data = [];

        $data['banner'] = HomeBanner::get();

        $data['categories'] = Category::with([
            'products' => function ($query) {
                $query->select('id', 'category_id', 'name', 'slug', 'image', 'item_code')
                    ->with('productAttributes:id,product_id,size_id,color_id,price,mrp');
            }
        ])->get();

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

    public function getUserData(Request $request)
    {
        // prx($request->all());

        $token = $request->token;

        $checkUser = TempUsers::where('token', $token)->first();

        if (isset($checkUser->id)) {
            // token exist in DB
            $data['user_type'] = $checkUser->user_type;
            $data['token'] = $checkUser->token;

            if (checkTokenExpiryInMinutes($checkUser->updated_at, 60)) {
                // token has expired
                $token = generateRandomString();

                $checkUser->token = $token;
                $checkUser->updated_at = date('Y-m-d h:i:s a', time());
                $checkUser->save();

                $data['token'] = $token;
            } else {
                // token  has not expired
            }


        } else {
            // token not exist in DB

            $user_id = rand(11111, 99999);
            $token = generateRandomString();
            $time = date('Y-m-d h:i:s a', time());

            TempUsers::create([
                'user_id' => $user_id,
                'token' => $token,
                'created_at' => $time,
                'updated_at' => $time,
            ]);

            $data['user_type'] = 2;
            $data['token'] = $token;

        }

        return $this->success(
            ['data' => $data],
            'Data Fetched Successfully'
        );

    }

    public function getFilterProducts($category_id, $size = [], $color = [], $brand = [], $attribute = [], $lowPrice, $highPrice)
    {

        $products = Product::where('category_id', $category_id);

        // dd($products);

        if (sizeof($brand) > 0) {
            // $products = $products->whereIn('brand_id', $brand);
            $products = Product::whereIn(
                'brand_id',
                $brand
            )->whereIn('id', $products->pluck('id'))->get();
        }

        if (sizeof($attribute) > 0) {
            $products = ProductAttribute::whereIn('attribute_value_id', $attribute)->whereIn('product_id', $products->pluck('id'))->get();

            $products = Product::whereIn('id', $products->pluck('product_id'))->get();

        }

        // if (sizeof($attribute) > 0) {
        //     $products = $products->withWhereHas('attribute', function ($q) use ($attribute) {
        //         $q->whereIn('attribute_value_id', $attribute);
        //     });
        // }

        $data = ProductAttr::whereIn('product_id', $products->pluck('id'))->get();

        if (sizeof($size) > 0) {
            // $products = $products->withWhereHas('productAttributes', function ($q) use ($size) {
            //     $q->whereIn('size_id', $size);
            // });
            $data = ProductAttr::whereIn('size_id', $size)->whereIn('id', $data->pluck('id'))->get();

        }

        if (sizeof($color) > 0) {
            // $products = $products->withWhereHas('productAttributes', function ($q) use ($color) {
            //     $q->whereIn('color_id', $color);
            // });

            $data = ProductAttr::whereIn('color_id', $color)->whereIn('id', $data->pluck('id'))->get();
        }

        if ($lowPrice != '' && $lowPrice != null && $highPrice != '') {
            // $products = $products->withWhereHas('productAttributes', function ($q) use ($lowPrice, $highPrice) {
            //     $q->whereBetween('price', [$lowPrice, $highPrice]);
            // });

            $data = ProductAttr::whereBetween('price', [$lowPrice, $highPrice])->whereIn('id', $data->pluck('id'))->get();

        }

        // $products = $products->with(['productAttributes'])->select('id', 'name', 'slug', 'image', 'item_code')->paginate(10);

        $data = Product::whereIn('id', $data->pluck('product_id'))->with('productAttributes')->select('id', 'name', 'slug', 'image', 'item_code')->paginate(10);

        // return $products;
        return $data;

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

    public function getCartData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'token' => 'required|exists:temp_users,token'
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            $userToken = TempUsers::where('token', $request->token)->first();
            $data = Cart::where('user_id', $userToken->user_id)->with('products')->get();

            return $this->success([
                'data' => $data
            ], 'Successfully data fetched');
        }

    }

    public function addToCart(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'token' => 'required|exists:temp_users,token',
            'product_id' => 'required|exists:products,id',
            'product_attr_id' => 'required|exists:product_attrs,id',
            'qty' => 'required|numeric|min:0|not_in:0',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            $user = TempUsers::where('token', $request->token)->first();

            $data = Cart::updateOrCreate(
                [
                    'user_id' => $user->user_id,
                    'product_id' => $request->product_id,
                    'product_attr_id' => $request->product_attr_id,
                ],
                [
                    'user_id' => $user->user_id,
                    'product_id' => $request->product_id,
                    'product_attr_id' => $request->product_attr_id,
                    'qty' => $request->qty,
                    'user_type' => $user->user_type
                ]
            );

            return $this->success([
                'data' => $data
            ], 'Successfully data fetched');
        }

    }

    public function removeCartData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'token' => 'required|exists:temp_users,token',
            'product_id' => 'required|exists:products,id',
            'product_attr_id' => 'required|exists:product_attrs,id',
            'qty' => 'required|numeric|min:0|not_in:0',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            $user = TempUsers::where('token', $request->token)->first();

            $cart = Cart::where('user_id', $user->user_id)
                ->where('product_id', $request->product_id)
                ->where('product_attr_id', $request->product_attr_id)
                ->first();

            if (isset($cart->id)) {
                $qty = $request->qty;
                if ($cart->qty == $qty) {
                    $cart->delete();
                } else if ($cart->qty > $qty) {
                    $cart->qty -= $qty;
                    $cart->save();
                } else {
                    $cart->delete();
                }
            }

            return $this->success([
                'data' => ''
            ], 'Cart Data Removed successfully');
        }
    }

}