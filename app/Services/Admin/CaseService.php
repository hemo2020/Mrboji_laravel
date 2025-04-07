<?php

namespace App\Services\Admin;
use App\Models\Cases;

class CaseService
{
    public function __construct()
    {
    }

    public function create($data)
    {
        return Cases::query()->create($data);
    }

    public function validatePartPricing($case): bool
    {
        foreach ($case->pricing as $price) {
            return (empty($price->part_no)) ? false : true;
        }
        return true;
    }
}


