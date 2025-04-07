<?php

namespace App\Http\Requests;

use App\Models\Cases;
use App\Services\Admin\BrandService;
use App\Services\Admin\ModelService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CaseRequest extends FormRequest
{
    public function prepareForValidation(): void
    {
        if ($this->method() == 'POST') {
            $this->merge(['created_by' => Auth::user()->id]);
        }
    }

    public function rules(): array
    {
        $rules = [
            'case_no' => ['required', 'string', 'max:255', 'unique:cases'],
            'brand' => ['required', 'string', 'max:255', 'exists:brands,id'],
            'model' => ['required', 'string', 'max:255', 'exists:models,id'],
            'year' => ['required', 'string', 'max:255'],
            'vin' => ['required', 'string', 'max:255'],
            'assigned_to' => ['nullable', 'numeric'],
            'date' => ['required', 'date'],
            'parts'   => ['required', 'array'],
            'parts.*'   => ['required', 'array'],
            'parts.*.part_name' => ['required', 'string'],
            'parts.*.qty' => ['required', 'numeric', 'min:1'],
        ];
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $case = $this->route('case');
            $rules['case_no'] = [
                'required', 'string', 'max:255',
                Rule::unique(Cases::class)->ignore($case),
            ];
        }

        if ($this->method() == 'POST') {
            $rules['created_by'] = ['required'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'parts'   => "Please add at list one part in case.",
            'parts.*.qty.required' => 'The quantity field is required.',
            'parts.*.qty.numeric' => 'The quantity must be a number.',
            'parts.*.qty.min' => 'The quantity must be at least :min.',
        ];
    }

    public function validated($key = null, $default = null)
    {
        $brands = app(BrandService::class)->getBrandDropdown();
        $models = app(ModelService::class)->getModelDropdown();
        $inputs = parent::validated();
        $inputs['date'] = !empty($inputs['date']) ? date('Y-m-d H:i:s', strtotime($inputs['date'])) : null;
        $inputs['brand'] = $brands[$this->brand];
        $inputs['model'] = $models[$this->model];
        return $inputs;
    }
}
