<?php

namespace App\Http\Requests;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:40', 'unique:users'],
            'phone' => ['required', 'max:30', 'unique:users'],
            'address' => ['nullable'],
            'city' => ['nullable'],
            'status' => ['nullable'],
            'role' => ['required'],
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $user = $this->route('user');
            $rules['name'] = [
                'required', 'string', 'max:30',
            ];
            $rules['email'] = [
                'required', 'string', 'max:40',
                Rule::unique(User::class)->ignore($user),
            ];
            $rules['phone'] = [
                'required', 'string', 'max:30',
                Rule::unique(User::class)->ignore($user),
            ];
            $rules['password'] = ['nullable', 'string', 'confirmed'];
        } else {
            $rules['password'] = ['required', 'string', 'confirmed'];
        }

        return $rules;
    }

    public function validated($key = null, $default = null)
    {
        $inputs = parent::validated();
        $inputs['status'] = !empty($inputs['status']) && $inputs['status'] == 'on' ? 1 : 0;
        return $inputs;
    }

}
