<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AuthStudentSignUpRequest extends FormRequest
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
            'full_name' => ['required', 'regex:/^[A-Za-z]+[A-Za-z ]*$/'],
            'serial_number' => ['required', 'regex:/^[0-9]+$/', 'min:7'],
            'phone_number' => ['required', 'regex:/^[0-9]+$/', 'min:8', 'max:10'],
            'email' => 'required|email',
            'password' => 'required|min:4',
            'parcours_id' => 'required|exists:parcours,id',
            'diplome_prepare_id' => 'required|exists:diplome_prepares,id',
        ];
    }
}
