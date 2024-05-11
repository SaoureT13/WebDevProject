<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'partner_id' => 'nullable|exists:users,id',
            'theme'=> 'required',
            'memory_problems'=> 'required',
            'global_objective'=> 'required',
            'specific_objective'=> 'required',
            'expected_result'=> 'required',
            'choice' => 'nullable',
            'societe_id' => $this->input('choice') ? 'nullable' : 'required|exists:societes,id',
            'company_name' => $this->input('choice') ? 'required' : 'nullable',
            'company_contact' => $this->input('choice') ? 'regex:/^[\d\s]+$/|max:10' : 'nullable',
        ];
    }
}
