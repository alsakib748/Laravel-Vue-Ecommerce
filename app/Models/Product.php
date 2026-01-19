<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use URL;

class Product extends Model
{

    protected $guarded = [];

    public function attribute()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id', 'id')->with('attribute_values');
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttr::class, 'product_id', 'id')->with('images');
    }

    protected function Image()
    {
        return Attribute::make(
            get: fn($value) => URL::to('' . $value)
        );
    }

}
