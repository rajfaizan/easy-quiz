<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:6',
            'description' => 'nullable|string',
            'questions' => 'required|array|min:1',
            'questions.*' => 'required|string',
            'options' => 'required|array',
            'options.*' => 'array|size:4',
            'options.*.*' => 'required|string',
            'correct_answer' => 'required|array',
            'correct_answer.*' => 'required|string|in:option1,option2,option3,option4',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Quiz title is required.',
            'semester.required' => 'Please select a semester.',
            'questions.*.required' => 'Each question must have a title.',
            'options.*.size' => 'Each question must have exactly 4 options.',
            'correct_answer.*.in' => 'Each correct answer must match an option (1 to 4).'
        ];
    }
}
