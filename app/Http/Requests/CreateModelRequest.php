<?php

namespace App\Http\Requests;

use App\Models\Models;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateModelRequest extends FormRequest
{

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255', 'unique:models'],
            'brand_id' => ['required', 'string', 'max:255'],
        ];
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $model = $this->route('model');
            $rules['name'] = [
                'required', 'string', 'max:255',
                Rule::unique(Models::class)->ignore($model),
            ];
        }

        return $rules;
    }
}
