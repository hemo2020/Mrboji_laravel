<?php

namespace App\Http\Requests;

use App\Models\Brand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateBrandRequest extends FormRequest
{

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255', 'unique:brands'],
        ];
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $brand = $this->route('brand');
            $rules['name'] = [
                'required', 'string', 'max:255',
                Rule::unique(Brand::class)->ignore($brand),
            ];
        }

        return $rules;
    }
}
