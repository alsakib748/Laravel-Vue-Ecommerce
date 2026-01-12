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

        $data['categories'] = Category::with('products')->get();

        $data['brands'] = Brand::get();

        return $this->success(
            ['data' => $data],
            'Home Page Data Fetched Successfully'
        );

    }

}