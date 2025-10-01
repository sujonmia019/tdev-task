<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\FormRequest;

class RegisterRequest extends FormRequest
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
            'username' => ['required','string','unique:users,username'],
            'email'    => ['required','email','unique:users,email'],
            'phone'    => ['required','string','unique:users,phone'],
            'password' => ['required','min:6','max:16']
        ];
    }
}
