<?php
return [
    'create_user' => [
        'email' => [
            'required' => 'Email is required.',
            'email' => 'Please enter a valid email address.',
            'maxlength' => 'Maximum 50 characters allowed',
        ],
        'name' => [
            'required' => 'Full name is required.',
            'maxlength' => 'Maximum 50 characters allowed',
        ],
        'role' => [
            'required' => 'Role is required.',
        ],
        'status' => [
            'required' => 'Status is required.',
        ]
    ],
    'fetch_success' => ':attribute fetched successfully.',
    'create_success' => ':attribute created successfully.',
    'update_success' => ':attribute updated successfully.',
    'update_failed' => 'Failed to update :attribute.',
    'delete_success' => ':attribute deleted successfully.',
    'delete_failed' => 'Failed to delete :attribute.',
    'status_change_success' => 'Status changed successfully',
    'failed_change_status' => 'Failed to change status'
];
