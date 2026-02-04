<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use App\Traits\ApiResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    use ApiResponse;


    public function index()
    {
        // dd("working");
        $data = Coupon::get();
        return view('admin.Coupon.coupon', get_defined_vars());
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validation = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'name' => 'required|string|max:255',
                'type' => 'required|numeric|in:1,2',
                'value' => 'required|numeric',
                'min_value' => 'required|numeric',
            ]
        );

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            Coupon::updateOrCreate(
                ['id' => $request->id],
                values: [
                    'name' => $request->name,
                    'type' => $request->type,
                    'value' => $request->value,
                    'min_value' => $request->min_value,
                ]
            );
            return $this->success(['reload' => true], 'Coupon Successfully updated');
        }

    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
