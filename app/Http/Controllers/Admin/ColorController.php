<?php

namespace App\Http\Controllers\Admin;

use App\Models\Color;
use App\Traits\ApiResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    use ApiResponse;


    public function index()
    {
        // dd("working");
        $data = Color::get();
        return view('admin.Color.color', get_defined_vars());
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validation = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'color' => 'required|string|max:255',
                'value' => 'required|string|max:255',
            ]
        );

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            Color::updateOrCreate(
                ['id' => $request->id],
                values: [
                    'color' => $request->color,
                    'slug' => Str::slug($request->color),
                    'value' => $request->value,
                ]
            );
            return $this->success(['reload' => true], 'Color Successfully updated');
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
