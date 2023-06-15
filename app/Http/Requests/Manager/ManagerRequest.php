<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;

class ManagerRequest extends FormRequest
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
            "name" => "required|string|max:200",
            "email" => "required|email|unique:managers,email",
            "phone" => "required|string|max:30",
            "password" => "required|string|min:6",
            "password_confirmation" => "required|string|min:6|same:password",
            "address" => "nullable|string",
            "photo" => "required_with:id|mimes:jpeg,png,jpg,gif"
        ];
    }
}
