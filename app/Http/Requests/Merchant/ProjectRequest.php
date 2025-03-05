<?php

namespace App\Http\Requests\Merchant;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|min:3',
            'brand_id' => 'required|exists:brands,id',
            'product_id' => 'required|exists:products,id',
            'priority' => 'required|in:low,medium,high',
            'guidelines' => 'nullable',
            'notes' => 'nullable|string',
            'service_id' => 'required|array', // Ensure it's an array
            'service_id.*' => 'required|exists:services,id', // Validate each item in the array
        ];
        if ($this->isMethod('post')) {
            $rules['images'] = 'required';
            $rules['images.*'] = 'image|mimes:jpg,jpeg,png,gif';
        } elseif ($this->isMethod('put')) {
            $rules['images'] = 'nullable';
            $rules['images.*'] = 'image|mimes:jpg,jpeg,png,gif';
        }

        return $rules;
    }
}
