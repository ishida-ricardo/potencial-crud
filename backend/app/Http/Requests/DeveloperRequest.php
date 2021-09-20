<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeveloperRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'sex' => [
                'required',
                Rule::in(['M', 'F']),
            ],
            'age' => 'required|gt:1',
            'hobby' => 'required|max:255',
            'birth_date' => 'required|date_format:Y-m-d'
        ];
    }
}
