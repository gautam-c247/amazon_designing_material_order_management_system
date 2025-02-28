<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class ServiceRequest extends BaseRequest
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
            'name' => 'required|string|max:100|min:3',
            'description' => 'required|string|max:255|min:3',
            'credit' => 'required|numeric|min:1|max:9999999999',
            'status' => 'required|in:1,0',
        ];
    }
}
