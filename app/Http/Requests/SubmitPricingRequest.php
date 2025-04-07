<?php

namespace App\Http\Requests;

use App\Models\Cases;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SubmitPricingRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'parts'   => ['required', 'array'],
            'parts.*'   => ['required', 'array'],
            'parts.*.id' => ['required', 'numeric'],
            'parts.*.part_no' => ['nullable', 'string'],
            'parts.*.price' => ['required_with:parts.*.part_no', 'nullable', 'numeric'],
            'parts.*.discount' => ['required_with:parts.*.part_no', 'nullable', 'numeric'],
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'parts.*.price' => [
                'required_with' => 'Please insert price and discount with part number.'
            ],
            'parts.*.discount' => [
                'required_with' => 'Please insert price and discount with part number.'
            ]
        ];
    }
}
