<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "name"    => 'required|string|max:100',
            "email"     => 'required|email|unique:users,email|max:100',
            "password" => "required|min:8|string",
            "password_confirmation" => "required|min:8|string|same:password",
            "phone"     => 'required|string|unique:users,phone|max:30',
            "address" => "nullable|string",
            "photo" => "required_without:id|mimes:jpeg,png,jpg,gif"
        ];
    }
}
