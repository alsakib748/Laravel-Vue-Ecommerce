<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tax;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TaxController extends Controller
{
    use ApiResponse;

    public function index()
    {
        // dd("working");
        $data = Tax::get();
        return view('admin.Tax.tax', get_defined_vars());
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required',
            'text' => 'required|string|max:255',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400);
        } else {
            Tax::updateOrCreate(
                ['id' => $request->id],
                [
                    'text' => $request->text,
                ]
            );
        }

        return $this->success(['reload' => true], 'Tax saved successfully');
    }
}