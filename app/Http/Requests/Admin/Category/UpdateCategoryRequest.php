<?php

namespace App\Http\Requests\Admin\Category;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends BaseRequest
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
        $categoryId = $this->route('category');
        return [
            'name' => 'string|required|max:100|unique:categories,name,' . $categoryId,
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                Rule::notIn([$categoryId]), // Ensure parent_id is not the same as the current category's id
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'name.unique' => 'Category title already exists',
        ];
    }
}
