<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->route('user'),
            // verifica se o método é POST e registra a senha do usuário
            'password' => $this->isMethod('post') ? 'required|string|min:8' : 'nullable|string|min:8',
            'is_admin' => 'sometimes|boolean',
        ];

        return $rules;
    }
}
