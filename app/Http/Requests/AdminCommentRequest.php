<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Professeur;

class AdminCommentRequest extends FormRequest
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
            'comment_theme' => 'required|string',
            'comment_problems' => 'required|string',
            'comment_global_obj' => 'required|string',
            'comment_specific_obj' => 'required|string',
            'comment_result_expected' => 'required|string',
            'professeur_id' => 'required|exists:professeurs,id',
        ];
    }
}
