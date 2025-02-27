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
        'contact_no' => [
            'maxlength' => 'Maximum 10 digits allowed.',
            'minlength' => 'Minimum 10 digits required',
            'digits' => 'No special characters allowed',
        ],
        'location' => [
            'required' => 'Location is required.',
            'maxlength' => 'Maximum 50 characters allowed',
        ],
        'profile_picture' => [
            'filesize' => 'File size must not exceed 2MB.',
        ],
        'gender' => [
            'required' => 'Gender is required.',
            'maxlength' => 'Gender cannot exceed 255 characters.',
        ],
        'date_of_birth' => [
            'required' => 'Date of birth is required.',
            'date' => 'Please enter a valid date.',
        ],
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
