<?php

namespace App\Services\Admin;
use App\Models\Brand;

class BrandService
{
    public function __construct()
    {
    }

    public function getBrandDropdown(): \Illuminate\Support\Collection
    {
        return Brand::query()->pluck('name', 'id');
    }
}


