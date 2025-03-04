<?php
return [
    'create_service' => [
        'name' => [
            'required' => 'Service Name is required',
            'maxlength' => 'Maximum 100 characters allowed',
            'minlength' => 'Minimum 3 characters required',
        ],
        'description' => [
            'required' => 'Service Description is required',
            'maxlength' => 'Maximum 255 characters allowed',
            'minlength' => 'Minimum 3 characters required',
        ],
        'credit' => [
            'required' => 'Service Credit is required',
            'number' => 'Service Credit must be a number',
            'min' => 'Service Credit must be at least 1',
            'maxlength' => 'Maximum 10 characters allowed',
        ],
        'status' => [
            'required' => 'Service Status is required',
        ],
    ],
   
];
