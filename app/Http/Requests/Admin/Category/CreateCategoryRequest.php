<?php

namespace App\Http\Requests\Admin\Category;

use App\Http\Requests\BaseRequest;

class CreateCategoryRequest extends BaseRequest
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
            'name' => 'string|required|max:100|min:3|unique:categories,name',
            'parent_id' => 'nullable|exists:categories,id'
        ];
    }
    public function messages(): array
    {
        return [
            'name.unique' => 'Category title already exists',
        ];
    }
}
