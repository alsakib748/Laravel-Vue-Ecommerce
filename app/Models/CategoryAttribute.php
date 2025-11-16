<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryAttribute extends Model
{


    protected $table = "category_attribute";

    protected $guarded = [];


    public function attribute()
    {
        return $this->hasOne(Attribute::class, 'id', 'attribute_id');
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class, 'attributes_id', 'attribute_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }


}