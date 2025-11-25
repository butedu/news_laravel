<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Contact Notification Recipient
    |--------------------------------------------------------------------------
    |
    | Email address that should receive alerts when a new contact request is
    | submitted. Defaults to ADMIN_EMAIL when defined, otherwise falls back to
    | the default "mail from" address so notifications are still delivered.
    */
    'notification_recipient' => env('ADMIN_EMAIL', env('MAIL_FROM_ADDRESS')),
];
