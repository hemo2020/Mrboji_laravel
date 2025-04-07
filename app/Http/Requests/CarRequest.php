<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Car;

class CarRequest extends FormRequest
{

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255', 'unique:cars'],
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:255'],
        ];
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $car = $this->route('car');
            $rules['name'] = [
                'required', 'string', 'max:255',
                Rule::unique(Car::class)->ignore($car),
            ];
        }

        return $rules;
    }
}
