<?php

namespace App\Http\Controllers\Admin;

use App\Models\Size;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{
    use ApiResponse;


    public function index()
    {
        // dd("working");
        $data = Size::get();
        return view('admin.Size.size', get_defined_vars());
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $validation = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'size' => 'required|string|max:255',
            ]
        );

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            Size::updateOrCreate(
                ['id' => $request->id],
                [
                    'size' => $request->size
                ]
            );
            return $this->success(['reload' => true], 'Size Successfully updated');
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
