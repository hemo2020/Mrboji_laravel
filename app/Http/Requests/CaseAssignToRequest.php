<?php

namespace App\Http\Requests;

use App\Models\Cases;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CaseAssignToRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'assigned_to' => ['required', 'numeric'],
        ];
    }
}
