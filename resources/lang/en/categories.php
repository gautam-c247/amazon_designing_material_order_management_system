<?php
return [
    'create_category' => [
        'name' => [
            'required' => 'Category Title is required',
            'maxlength' => 'Maximum 100 characters allowed',
            'minlength' => 'Minimum 3 characters required',
        ],
    ],
    'fetch_success' => ':attribute fetched successfully.',
    'create_success' => ':attribute created successfully.',
    'create_failed' => 'Failed to create :attribute.',
    'update_success' => ':attribute updated successfully.',
    'update_failed' => 'Failed to update :attribute.',
    'delete_success' => ':attribute deleted successfully.',
    'delete_failed' => 'Failed to delete :attribute.',
    'status_change_success' => 'Status changed successfully.',
    'status_change_failed' => 'Failed to change status.'
];
