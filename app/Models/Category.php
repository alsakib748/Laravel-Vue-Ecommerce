<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use URL;

class Category extends Model
{
    protected $guarded = [];


    public function attribute()
    {
        return $this->belongsToMany(Attribute::class, 'category_attribute', 'category_id', 'attribute_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_category_id', 'id');
    }

    protected function Image()
    {
        return Attribute::make(
            get: fn($value) => URL::to('' . $value)
        );
    }

}