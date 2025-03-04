<?php
return [
    'create_notification' => [
        'title' => [
            'required' => 'Title is required',
            'maxlength' => 'Maximum 255 characters allowed',
        ],
        'message' => [
            'required' => 'Message is required',
            'maxlength' => 'Maximum 1000 characters allowed',
        ],
        'recipients' => [
            'required' => 'Recipients are required',
        ],
        'push_time' => [
            'required' => 'Push time is required',
            'date_format' => 'Invalid date format. Use Y-m-d H:i:s',
            'min' => 'Push time must be in the future',
            ]
    ],
];
