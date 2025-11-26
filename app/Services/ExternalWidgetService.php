<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ExternalWidgetService
{
    private ?array $exchangeRatesCache = null;

    public function getSidebarData(): array
    {
        $weather = $this->getWeatherSnapshot();
        $airQuality = $this->getAirQualitySnapshot();
        $exchangeRates = $this->getExchangeRatesSnapshot();

        return [
            'weather' => $weather,
            'air_quality' => $airQuality,
            'gold' => $this->getGoldSnapshot(),
            'fuel' => $this->getFuelSnapshot(),
            'exchange' => $exchangeRates,
        ];
    }

    public function getPrimaryWeatherLocation(): ?array
    {
        $preferredKey = config('widgets.header_weather_key');
        $weather = $this->getWeatherSnapshot();

        if (empty($weather)) {
            return null;
        }

        if ($preferredKey) {
            foreach ($weather as $entry) {
                if (($entry['name'] ?? null) === $preferredKey) {
                    return $entry;
                }
            }
        }

        return $weather[0];
    }

    private function getWeatherSnapshot(): array
    {
        $locations = config('widgets.weather_locations', []);
        if (empty($locations)) {
            return [];
        }

        $minutes = config('widgets.cache_minutes.weather', 30);

        return Cache::remember('sidebar_widget_weather', now()->addMinutes($minutes), function () use ($locations) {
            $results = [];

            foreach ($locations as $location) {
                if (!isset($location['lat'], $location['lon'], $location['name'])) {
                    continue;
                }

                try {
                    $response = Http::timeout(8)
                        ->acceptJson()
                        ->get('https://api.open-meteo.com/v1/forecast', [
                            'latitude' => $location['lat'],
                            'longitude' => $location['lon'],
                            'current' => 'temperature_2m,relative_humidity_2m,weather_code',
                            'timezone' => 'Asia/Bangkok',
                            'forecast_days' => 1,
                        ]);

                    if ($response->failed()) {
                        continue;
                    }

                    $payload = $response->json();
                    $current = $payload['current'] ?? [];

                    if (empty($current)) {
                        continue;
                    }

                    $code = $current['weather_code'] ?? null;
                    $timestamp = $current['time'] ?? null;

                    $results[] = [
                        'name' => $location['name'],
                        'temperature' => isset($current['temperature_2m']) ? round((float) $current['temperature_2m']) : null,
                        'humidity' => isset($current['relative_humidity_2m']) ? round((float) $current['relative_humidity_2m']) : null,
                        'code' => $code,
                        'description' => $this->mapWeatherCode($code),
                        'icon' => $this->mapWeatherIcon($code),
                        'updated_at' => $timestamp ? Carbon::parse($timestamp, 'Asia/Bangkok')->setTimezone('Asia/Ho_Chi_Minh') : null,
                    ];
                } catch (\Throwable $exception) {
                    continue;
                }
            }

            return $results;
        });
    }

    private function getAirQualitySnapshot(): array
    {
        $locations = config('widgets.air_quality_locations', config('widgets.weather_locations', []));
        if (empty($locations)) {
            return [];
        }

        $minutes = config('widgets.cache_minutes.air_quality', 20);

        return Cache::remember('sidebar_widget_air_quality', now()->addMinutes($minutes), function () use ($locations) {
            $results = [];

            foreach ($locations as $location) {
                if (!isset($location['lat'], $location['lon'], $location['name'])) {
                    continue;
                }

                try {
                    $response = Http::timeout(8)
                        ->acceptJson()
                        ->get('https://air-quality-api.open-meteo.com/v1/air-quality', [
                            'latitude' => $location['lat'],
                            'longitude' => $location['lon'],
                            'hourly' => 'pm2_5,pm10,us_aqi',
                            'timezone' => 'Asia/Bangkok',
                            'forecast_days' => 1,
                        ]);

                    if ($response->failed()) {
                        continue;
                    }

                    $payload = $response->json();
                    $hourly = $payload['hourly'] ?? [];

                    $times = $hourly['time'] ?? [];
                    $pm25 = $hourly['pm2_5'] ?? [];
                    $pm10 = $hourly['pm10'] ?? [];
                    $aqi = $hourly['us_aqi'] ?? [];

                    if (empty($times)) {
                        continue;
                    }

                    $index = null;
                    $nowBangkok = Carbon::now('Asia/Bangkok');
                    foreach ($times as $key => $timeString) {
                        try {
                            $time = Carbon::parse($timeString, 'Asia/Bangkok');
                        } catch (\Throwable $exception) {
                            continue;
                        }

                        if ($time->lessThanOrEqualTo($nowBangkok)) {
                            $index = $key;
                        }
                    }

                    if ($index === null) {
                        $index = count($times) - 1;
                    }

                    $timestamp = $times[$index] ?? null;
                    $aqiValue = isset($aqi[$index]) ? (float) $aqi[$index] : null;
                    $pm25Value = isset($pm25[$index]) ? round((float) $pm25[$index]) : null;
                    $pm10Value = isset($pm10[$index]) ? round((float) $pm10[$index]) : null;

                    $category = $this->mapAirQualityCategory($aqiValue);

                    $results[] = [
                        'name' => $location['name'],
                        'aqi' => $aqiValue !== null ? (int) round($aqiValue) : null,
                        'pm25' => $pm25Value,
                        'pm10' => $pm10Value,
                        'category' => $category['label'],
                        'badge_class' => $category['badge_class'],
                        'updated_at' => $timestamp ? Carbon::parse($timestamp, 'Asia/Bangkok')->setTimezone('Asia/Ho_Chi_Minh') : null,
                    ];
                } catch (\Throwable $exception) {
                    continue;
                }
            }

            return $results;
        });
    }

    private function getGoldSnapshot(): ?array
    {
        $minutes = config('widgets.cache_minutes.gold', 15);

        return Cache::remember('sidebar_widget_gold', now()->addMinutes($minutes), function () {
            try {
                $response = Http::timeout(8)
                    ->acceptJson()
                    ->get('https://economia.awesomeapi.com.br/last/XAU-USD');

                if ($response->failed()) {
                    return null;
                }

                $payload = $response->json();
                $entry = $payload['XAUUSD'] ?? null;

                if (!$entry) {
                    return null;
                }

                $priceUsd = (float) ($entry['bid'] ?? 0);

                if ($priceUsd <= 0) {
                    return null;
                }

                $usdToVnd = $this->getUsdToVndRate();
                $updatedAt = $entry['create_date'] ?? null;

                return [
                    'price_usd' => round($priceUsd, 2),
                    'price_vnd_per_ounce' => $usdToVnd ? round($priceUsd * $usdToVnd) : null,
                    'price_vnd_per_luong' => $usdToVnd ? round($priceUsd * 1.20565 * $usdToVnd) : null,
                    'updated_at' => $updatedAt
                        ? Carbon::createFromFormat('Y-m-d H:i:s', $updatedAt, 'America/Sao_Paulo')->setTimezone('Asia/Ho_Chi_Minh')
                        : null,
                ];
            } catch (\Throwable $exception) {
                return null;
            }
        });
    }

    private function getFuelSnapshot(): ?array
    {
        $minutes = config('widgets.cache_minutes.fuel', 60);

        return Cache::remember('sidebar_widget_fuel', now()->addMinutes($minutes), function () {
            $apiKey = config('services.alpha_vantage.key', 'demo');

            try {
                $response = Http::timeout(10)
                    ->acceptJson()
                    ->get('https://www.alphavantage.co/query', [
                        'function' => 'WTI',
                        'interval' => 'monthly',
                        'apikey' => $apiKey,
                    ]);

                if ($response->failed()) {
                    return null;
                }

                $payload = $response->json();
                $series = $payload['data'] ?? [];
                $latest = $series[0] ?? null;

                if (!$latest) {
                    return null;
                }

                $usdPerBarrel = (float) ($latest['value'] ?? 0);

                if ($usdPerBarrel <= 0) {
                    return null;
                }

                $usdToVnd = $this->getUsdToVndRate();
                $usdPerLiter = $usdPerBarrel / 158.987;

                return [
                    'usd_per_barrel' => round($usdPerBarrel, 2),
                    'usd_per_liter' => round($usdPerLiter, 3),
                    'vnd_per_liter' => $usdToVnd ? round($usdPerLiter * $usdToVnd) : null,
                    'updated_at' => isset($latest['date'])
                        ? Carbon::parse($latest['date'], 'UTC')->setTimezone('Asia/Ho_Chi_Minh')
                        : null,
                ];
            } catch (\Throwable $exception) {
                return null;
            }
        });
    }

    private function getExchangeRatesSnapshot(): array
    {
        if ($this->exchangeRatesCache !== null) {
            return $this->exchangeRatesCache;
        }

        $pairs = config('widgets.currency_pairs', []);
        if (empty($pairs)) {
            $this->exchangeRatesCache = [];
            return [];
        }

        $minutes = config('widgets.cache_minutes.exchange_rate', 120);

        $results = Cache::remember('sidebar_widget_exchange_rates', now()->addMinutes($minutes), function () use ($pairs) {
            $grouped = [];

            foreach ($pairs as $pair) {
                $base = strtoupper($pair['base'] ?? '');
                $quote = strtoupper($pair['quote'] ?? '');

                if ($base === '' || $quote === '') {
                    continue;
                }

                $grouped[$base][] = $pair;
            }

            $responses = [];
            foreach ($grouped as $base => $items) {
                try {
                    $response = Http::timeout(8)
                        ->acceptJson()
                        ->get("https://open.er-api.com/v6/latest/{$base}");

                    if ($response->failed()) {
                        continue;
                    }

                    $payload = $response->json();
                    $rates = $payload['rates'] ?? [];
                    $updatedAt = isset($payload['time_last_update_utc'])
                        ? Carbon::parse($payload['time_last_update_utc'], 'UTC')->setTimezone('Asia/Ho_Chi_Minh')
                        : null;

                    $responses[$base] = [
                        'rates' => $rates,
                        'updated_at' => $updatedAt,
                    ];
                } catch (\Throwable $exception) {
                    continue;
                }
            }

            $orderedResults = [];
            foreach ($pairs as $pair) {
                $base = strtoupper($pair['base'] ?? '');
                $quote = strtoupper($pair['quote'] ?? '');

                if ($base === '' || $quote === '') {
                    continue;
                }

                $data = $responses[$base] ?? null;
                $rate = $data && isset($data['rates'][$quote]) ? (float) $data['rates'][$quote] : null;

                $precision = isset($pair['precision']) ? (int) $pair['precision'] : 2;
                $inversePrecision = isset($pair['inverse_precision']) ? (int) $pair['inverse_precision'] : 6;

                $orderedResults[] = [
                    'label' => $pair['label'] ?? "{$base}/{$quote}",
                    'base' => $base,
                    'quote' => $quote,
                    'rate' => $rate !== null ? round($rate, $precision) : null,
                    'inverse_rate' => $rate && $rate > 0 ? round(1 / $rate, $inversePrecision) : null,
                    'updated_at' => $data['updated_at'] ?? null,
                    'precision' => $precision,
                    'inverse_precision' => $inversePrecision,
                ];
            }

            return $orderedResults;
        });

        $this->exchangeRatesCache = $results;

        return $results;
    }

    private function getUsdToVndRate(): ?float
    {
        foreach ($this->getExchangeRatesSnapshot() as $rate) {
            if ($rate['base'] === 'USD' && $rate['quote'] === 'VND' && $rate['rate'] !== null) {
                return (float) $rate['rate'];
            }
        }

        return null;
    }

    private function mapWeatherCode(?int $code): string
    {
        return match ($code) {
            0 => 'Trời quang',
            1, 2 => 'Ít mây',
            3 => 'Nhiều mây',
            45, 48 => 'Sương mù',
            51, 53, 55 => 'Mưa phùn',
            56, 57 => 'Mưa phùn lạnh',
            61, 63, 65 => 'Mưa rào',
            66, 67 => 'Mưa lạnh',
            71, 73, 75 => 'Tuyết rơi',
            77 => 'Băng tuyết',
            80, 81, 82 => 'Mưa rào',
            85, 86 => 'Mưa tuyết',
            95 => 'Dông',
            96, 99 => 'Dông kèm mưa đá',
            default => 'Đang cập nhật',
        };
    }

    private function mapWeatherIcon(?int $code): string
    {
        return match ($code) {
            0 => 'fa-sun-o',
            1, 2 => 'fa-cloud',
            3 => 'fa-cloud',
            45, 48 => 'fa-cloud',
            51, 53, 55 => 'fa-umbrella',
            56, 57 => 'fa-asterisk',
            61, 63, 65 => 'fa-umbrella',
            66, 67 => 'fa-umbrella',
            71, 73, 75 => 'fa-snowflake-o',
            77 => 'fa-snowflake-o',
            80, 81, 82 => 'fa-umbrella',
            85, 86 => 'fa-snowflake-o',
            95 => 'fa-bolt',
            96, 99 => 'fa-bolt',
            default => 'fa-cloud',
        };
    }

    private function mapAirQualityCategory(?float $aqi): array
    {
        if ($aqi === null) {
            return [
                'label' => 'Đang cập nhật',
                'badge_class' => 'is-unknown',
            ];
        }

        if ($aqi <= 50) {
            return [
                'label' => 'Tốt',
                'badge_class' => 'is-good',
            ];
        }

        if ($aqi <= 100) {
            return [
                'label' => 'Trung bình',
                'badge_class' => 'is-moderate',
            ];
        }

        if ($aqi <= 150) {
            return [
                'label' => 'Nhạy cảm',
                'badge_class' => 'is-sensitive',
            ];
        }

        if ($aqi <= 200) {
            return [
                'label' => 'Xấu',
                'badge_class' => 'is-unhealthy',
            ];
        }

        if ($aqi <= 300) {
            return [
                'label' => 'Rất xấu',
                'badge_class' => 'is-very-unhealthy',
            ];
        }

        return [
            'label' => 'Nguy hại',
            'badge_class' => 'is-hazardous',
        ];
    }
}
