<?php

return [
    'weather_locations' => [
        [
            'name' => 'Hà Nội',
            'lat' => 21.0285,
            'lon' => 105.8542,
        ],
        [
            'name' => 'TP. Hồ Chí Minh',
            'lat' => 10.8231,
            'lon' => 106.6297,
        ],
        [
            'name' => 'Đà Nẵng',
            'lat' => 16.0544,
            'lon' => 108.2022,
        ],
        [
            'name' => 'Cần Thơ',
            'lat' => 10.0452,
            'lon' => 105.7469,
        ],
        [
            'name' => 'Hải Phòng',
            'lat' => 20.8449,
            'lon' => 106.6881,
        ],
    ],

    'header_weather_key' => 'TP. Hồ Chí Minh',

    'air_quality_locations' => [
        [
            'name' => 'Hà Nội',
            'lat' => 21.0285,
            'lon' => 105.8542,
        ],
        [
            'name' => 'TP. Hồ Chí Minh',
            'lat' => 10.8231,
            'lon' => 106.6297,
        ],
        [
            'name' => 'Đà Nẵng',
            'lat' => 16.0544,
            'lon' => 108.2022,
        ],
    ],

    'currency_pairs' => [
        [
            'base' => 'USD',
            'quote' => 'VND',
            'label' => 'USD/VND',
            'precision' => 0,
            'inverse_precision' => 5,
        ],
        [
            'base' => 'EUR',
            'quote' => 'VND',
            'label' => 'EUR/VND',
            'precision' => 0,
            'inverse_precision' => 5,
        ],
        [
            'base' => 'USD',
            'quote' => 'JPY',
            'label' => 'USD/JPY',
            'precision' => 2,
            'inverse_precision' => 6,
        ],
    ],

    'cache_minutes' => [
        'weather' => 30,
        'air_quality' => 20,
        'gold' => 15,
        'fuel' => 60,
        'exchange_rate' => 120,
    ],
];
