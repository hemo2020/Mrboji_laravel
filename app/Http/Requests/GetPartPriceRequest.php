<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetPartPriceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'part_no' => ['required', 'string'],
        ];
    }
}
