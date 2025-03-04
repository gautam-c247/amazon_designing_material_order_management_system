<?php
return [
    "per_page" => 20,
    "menus" => [
        "dashboard" => [
            "label" => "Dashboard",
            "route" => 'admin.dashboard',
            "icon" => "material-symbols:dashboard-rounded",
        ],
        "user" => [
            "label" => "User",
            "route" => 'users.index',
           "icon" => "material-symbols:group-rounded",
        ],
        "Category" => [
            "label" => "Category",
            "route" => 'category.index',
            "icon" => "material-symbols:category-rounded",
        ],
        "Service" => [
            "label" => "Service",
            "route" => 'service.index',
            "icon" => "material-symbols:build",
        ],
        "Notification" => [
            "label" => "Notification",
            "route" => 'notification.index',
            "icon" => "material-symbols:notifications-active",
        ],
    ],
    "route_prefix" => env("ADMIN_ROUTE_PREFIX", "admin"),
];
