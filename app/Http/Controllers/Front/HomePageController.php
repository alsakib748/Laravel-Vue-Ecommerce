<?php

namespace App\Http\Controllers\Front;

use App\Models\Brand;
use App\Models\Category;
use App\Models\HomeBanner;
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

        return $this->success(
            ['data' => $data],
            'Categories Data Fetched Successfully'
        );
    }

}
