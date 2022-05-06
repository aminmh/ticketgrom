<?php

return [
    'name' => 'Setting',

    'settingable_name' => [
        \App\Models\Message::class => [
            "base" => "message_setting",
            "notification" => "message_notification_setting"
        ],
        \App\Models\Ticket::class => [
            "base" => "ticket_setting",
            "notification" => "ticket_notification_setting"
        ],
        \App\Models\Department::class => [
            "base" => "department_setting",
            "notification" => "department_notification_setting"
        ],
    ],

    'schema' => [
        \App\Models\Message::class => "../Schema/",
        \App\Models\Ticket::class => "",
        \App\Models\Department::class => "",
    ]
];
