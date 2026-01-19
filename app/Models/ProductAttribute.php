<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $guarded = [];

    public function attribute_values()
    {
        return $this->belongsTo(Attribute::class, 'attribute_value_id', 'id');
    }

}