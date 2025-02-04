<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->filled('status')) {
            return Auth::user()->can('change-completion-status', $this->route('task'));
        }
        if ($this->filled('assignment')) {
            return Auth::user()->can('assign-people', $this->route('task'));
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->filled('status')) {
            return [
                'is_completed' => ['required', 'boolean']
            ];
        }
        if ($this->filled('assignment')) {
            return [
                'user_id' => ['nullable', 'exists:users,id']
            ];
        }
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'user_id' => 'assigned to'
        ];
    }
}
