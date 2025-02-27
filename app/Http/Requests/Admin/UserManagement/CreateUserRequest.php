<?php

namespace App\Http\Requests\Admin\UserManagement;

use App\Http\Requests\BaseRequest;

class CreateUserRequest extends BaseRequest
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
            'email' => 'required|email|max:50|unique:users,email',
            'name' => 'required|string|max:50',
            'contact_no' => 'nullable|digits:10',
            'location' => 'nullable|string|max:50',
            'country_code' => 'nullable|string|max:5',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gender' => 'required|string|max:10',
            'date_of_birth' => 'required|date',
            'location' => 'required|string|max:50'
        ];
    }
}
