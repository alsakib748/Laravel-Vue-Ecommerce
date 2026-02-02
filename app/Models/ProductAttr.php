<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttr extends Model
{
    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(ProductAttrImages::class, 'product_attr_id', 'id');
    }

    public function sizes()
    {
        return $this->hasOne(Size::class, 'id', 'size_id');
    }

    public function colors()
    {
        return $this->hasOne(Color::class, 'id', 'color_id');
    }

}
