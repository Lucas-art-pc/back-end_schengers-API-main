<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ActivityCourseRequest extends FormRequest
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
            'title_activity'                           => ['required', 'string', 'min:3', 'max:255'],
            'description_activity'                     => ['nullable', 'string', 'max:1000'],
            'question_activity'                        => ['required', 'string', 'min:5'],
            'alternatives'                             => ['required', 'array', 'min:2', 'max:6'],
            'alternatives.*.title_alternative'         => ['required', 'string', 'max:10'],
            'alternatives.*.text_alternative'          => ['required', 'string', 'max:500'],
            'alternatives.*.correct_alternative'       => ['required', 'boolean'],


            'alternatives.*.id_alternative'            => ['nullable', 'integer', 'exists:tb_alternative,id_alternative'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $alternatives = $this->input('alternatives', []);

            $correctCount = collect($alternatives)
                ->filter(fn($alt) => ($alt['correct_alternative'] ?? false) == true)
                ->count();

            if ($correctCount === 0) {
                $validator->errors()->add(
                    'alternatives',
                    'Marque exatamente uma alternativa como correta.'
                );
            }

            if ($correctCount > 1) {
                $validator->errors()->add(
                    'alternatives',
                    'Apenas uma alternativa pode ser marcada como correta.'
                );
            }
        });
    }
}
