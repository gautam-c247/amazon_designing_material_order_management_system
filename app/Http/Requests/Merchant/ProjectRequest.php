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
        return [
            'name' => 'required|string|min:3',
            'brand_id' => 'required|exists:brands,id',
            'product_id' => 'required|exists:products,id',
            'priority' => 'required|in:low,medium,high',
            'guidelines' => 'nullable|string',
            'notes' => 'nullable|string',
            'service_id' => 'required|exists:services,id',
        ];
    }
}
