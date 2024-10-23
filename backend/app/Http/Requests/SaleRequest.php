<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
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
            'value' => 'required|numeric',
            // verifica se o método é POST e se o id do usuário é informado
            'user_id' => $this->isMethod('post') ? 'required|exists:users,id' : 'nullable|exists:users,id',
        ];

        return $rules;
    }
}
