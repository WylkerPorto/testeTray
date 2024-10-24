<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class SellerRequest extends FormRequest
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
        $sellerId = $this->route('seller') ? Crypt::decryptString($this->route('seller')) : null;
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:sellers,email,' . $sellerId,
        ];

        return $rules;
    }
}