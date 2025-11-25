<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Newsletter Base URL
    |--------------------------------------------------------------------------
    |
    | When generating links inside newsletter emails, we will prepend this
    | base URL. This allows the application to send emails from background
    | jobs (where the current request URL is not available) while still
    | pointing recipients to the correct public domain. If this value is not
    | provided we will fall back to the application's APP_URL value.
    |
    */

    'base_url' => env('NEWSLETTER_BASE_URL'),
];
