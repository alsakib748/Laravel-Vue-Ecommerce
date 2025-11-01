<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];


    public function attribute()
    {
        return $this->belongsToMany(Attribute::class, 'category_attribute', 'category_id', 'attribute_id');
    }

}