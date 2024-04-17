<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "name" => ['required', 'max:255'],
            'image' => ['nullable', 'image'],
            "description" => ['nullable', 'string'],
            'due_date' => ['required', 'date'],
            'priority' => ['required', Rule::in(['low', 'medium', 'high'])],
            'status' => ['required', Rule::in(['pending', 'in_progress', 'completed'])],
            'project_id' => ['required', 'exists:projects,id'],
            'assigned_user_id' => ['required', 'exists:users,id']
        ];
    }
}