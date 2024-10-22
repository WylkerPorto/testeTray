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
        ];

        // Se for uma requisição POST (criação), exigir o campo user_id
        if ($this->isMethod('post')) {
            $rules['user_id'] = 'required|exists:users,id';
        }

        // Se for uma requisição PUT ou PATCH (atualização), user_id é opcional
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['user_id'] = 'nullable|exists:users,id';  // user_id opcional na atualização
        }

        return $rules;
    }
}
