<?php
return [
    'register' => [
        'name' => [
            'required' => 'Full Name is required',
            'minlength' => 'Full Name must be at least 3 characters',
            'maxlength' => 'Full Name must not exceed 255 characters',
        ],
        'email' => [
            'required' => 'Email is required',
            'email' => 'Please enter a valid email address',
            'maxlength' => 'Email must not exceed 255 characters',
        ],
        'phone' => [
            'required' => 'Phone Number is required',
            'digits' => 'Phone Number must be numeric',
        ],
        'password' => [
            'required' => 'Password is required',
            'minlength' => 'Password must be at least 8 characters',
        ],
        'password_confirmation' => [
            'required' => 'Confirm Password is required',
            'equalTo' => 'Confirm Password must match the Password',
        ],
        'terms' => [
            'required' => 'You must accept the Terms & Conditions',
        ],
        'success' => 'We have sent you an email to verify your account',
    ],
    'create_brand' => [
        'name' => [
            'required' => 'Name is required',
            'minlength' => 'Name must be at least 3 characters',
            'maxlength' => 'Name must not exceed 255 characters',
        ],
        'category_id' => [
            'required' => 'Category is required',
        ],
        'logo' => [
            'required' => 'Logo is required',
            'extension' => 'Logo must be a valid image file (jpg, jpeg, png, gif)',
        ],
        'website_url' => [
            'url' => 'Please enter a valid URL',
        ],
        'about' => [
            'maxlength' => 'About must not exceed 1000 characters',
        ],
        'pronunciation' => [
            'maxlength' => 'Pronunciation must not exceed 255 characters',
        ],
        'instagram_url' => [
            'url' => 'Please enter a valid URL',
        ],
    ],
    'create_product' => [
        'name' => [
            'required' => 'Name is required',
            'minlength' => 'Name must be at least 3 characters',
            'maxlength' => 'Name must not exceed 255 characters',
        ],
        'brand_id' => [
            'required' => 'Brand is required',
        ],
        'image' => [
            'required' => 'Please select atleast one image',
            'extension' => 'Image must be a valid image file (jpg, jpeg, png, gif)',
        ],
        'description' => [
            'maxlength' => 'Description must not exceed 1000 characters',
            'required' => 'Description is required',
        ],
    ],
    'create_project' => [
        'name' => [
            'required' => 'Name is required',
            'minlength' => 'Name must be at least 3 characters',
            'maxlength' => 'Name must not exceed 255 characters',
        ],
        'user_id' => [
            'required' => 'Merchant is required',
        ],
        'brand_id' => [
            'required' => 'Brand is required',
        ],
        'product_id' => [
            'required' => 'Product is required',
        ],
        'priority' => [
            'required' => 'Priority is required',
        ],
        'guidelines' => [
            'maxlength' => 'Guidelines must not exceed 1000 characters',
        ],
        'notes' => [
            'maxlength' => 'Notes must not exceed 1000 characters',
        ],
    ],
];
