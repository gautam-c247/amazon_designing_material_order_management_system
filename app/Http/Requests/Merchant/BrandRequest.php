<?php

namespace App\Http\Requests\Merchant;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3'],
            'category_id' => ['required', 'exists:categories,id'],
            'logo' => ['nullable', 'image'],
            'website_url' => ['nullable', 'url'],
            'about' => ['nullable', 'string'],
            'pronunciation' => ['nullable', 'string'],
            'instagram_url' => ['nullable', 'url'],
        ];

        if ($this->isMethod('post')) {
            $rules['logo'] = ['required', 'image'];
        }

        return $rules;
    }
}
