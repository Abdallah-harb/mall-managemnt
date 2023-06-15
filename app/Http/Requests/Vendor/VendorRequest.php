<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            "department_id" => "required|integer|exists:departments,id",
            "name" => "required|string|max:100",
            "phone" => "required|string|max:30",
            "description" => "required|string|max:200",
            "logo" => "nullable|mimes:jpg,png,jpeg,gif"
        ];
    }
}
