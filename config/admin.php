<?php
return [
    "per_page" => 20,
    "menus" => [
        "dashboard" => [
            "label" => "Dashboard",
            "route" => 'admin.dashboard',
            "icon" => "material-symbols:dashboard-rounded",
        ],
        "Category" => [
            "label" => "Category",
            "route" => 'category.index',
           "icon" => "material-symbols:category-rounded",
        ],
        "user" => [
            "label" => "User",
            "route" => 'users.index',
           "icon" => "material-symbols:group-rounded",
        ],
    ],
    "route_prefix" => env("ADMIN_ROUTE_PREFIX", "admin"),
];
