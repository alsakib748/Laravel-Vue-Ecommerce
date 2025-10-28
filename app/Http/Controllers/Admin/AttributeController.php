<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;

use App\Traits\ApiResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{

    use ApiResponse;

    // todo: Attribute Name
    public function index_attribute_name()
    {
        // dd("working");
        $data = Attribute::get();
        return view('admin.Attribute.attribute', get_defined_vars());
    }

    public function store_attribute_name(Request $request)
    {
        // dd($request->all());
        $validation = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]
        );

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            Attribute::updateOrCreate(
                ['id' => $request->id],
                values: [
                    'name' => $request->name,
                    'slug' => Str::slug($request->slug),
                ]
            );
            return $this->success(['reload' => true], 'Attribute Successfully updated');
        }
    }

    // todo: Attribute Value
    public function index_attribute_value()
    {
        // dd("working");
        $data = AttributeValue::with('attribute')->get();
        $attributes = Attribute::get();
        return view('admin.Attribute.attribute_value', get_defined_vars());
    }

    public function store_attribute_value(Request $request)
    {
        // dd($request->all());
        $validation = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'attributes_id' => 'required|exists:attributes,id',
                'value' => 'required|string|max:255'
            ]
        );

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            AttributeValue::updateOrCreate(
                ['id' => $request->id],
                values: [
                    'attributes_id' => $request->attributes_id,
                    'value' => $request->value,
                ]
            );
            return $this->success(['reload' => true], 'Attribute Value Successfully updated');
        }

    }


    public function show(string $id)
    {

    }

    public function edit(string $id)
    {

    }

    public function update(Request $request, string $id)
    {

    }

    public function destroy(string $id)
    {

    }

}
