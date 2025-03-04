<?php

namespace App\Http\Requests\Merchant;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|min:3|max:255',
            'brand_id' => 'required|integer',
            'description' => 'nullable|string|max:1000',
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

    public function messages()
    {
        return [
            'name.required' => __('merchant.create_product.name.required'),
            'name.min' => __('merchant.create_product.name.minlength'),
            'name.max' => __('merchant.create_product.name.maxlength'),
            'brand_id.required' => __('merchant.create_product.brand_id.required'),
            'images.required' => __('merchant.create_product.image.required'),
            'images.*.mimes' => __('merchant.create_product.image.extension'),
            'description.max' => __('merchant.create_product.description.maxlength'),
        ];
    }
}
