<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use URL;

class Brand extends Model
{

    protected $guarded = [];

    protected function Image()
    {
        return Attribute::make(
            get: fn($value) => URL::to('' . $value)
        );
    }

}
