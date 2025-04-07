<?php

namespace App\Services\Admin;

use App\Models\Models;

class ModelService
{
    public function __construct()
    {
    }

    public function getModelDropdown(): \Illuminate\Support\Collection
    {
        return Models::query()->pluck('name', 'id');
    }
}


