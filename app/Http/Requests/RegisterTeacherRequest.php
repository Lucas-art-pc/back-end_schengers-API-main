<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterTeacherRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:6|max:100',
            'email' => 'required|email|unique:tb_teacher,email',
            'apresentation' => 'required|min:10|max:150',
            'password' => 'required|min:8|confirmed',
            'term_privacy' => 'required|accepted',
        ];
    }
}
