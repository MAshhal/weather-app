<?php

use Dotenv\Dotenv;
use Mystic\WeatherApp\WeatherService;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

/**
 * Call code here
 */

$weatherService = WeatherService::create();
$city = "Lahore";

echo "Getting weather for $city...\n";
$weather = $weatherService->getCurrentWeather($city);

$location = $weather['location'];
$data = $weather['data'];

echo "\n";
echo "Location\n";
echo "--------\n";
foreach ($location as $key => $value) {
    $formatted_key = match ($key) {
        'tz_id' => "Timezone",
        'lat' => 'Latitude',
        'lon' => 'Longitude',
        'localtime' => 'Local Time',
        'localtime_epoch' => 'Local Time (Epoch seconds)',
        default => ucwords($key)
    };

    $formatted_value = match ($key) {
        'lat', 'lon' => "{$value}°",
        default => $value
    };

    echo " {$formatted_key} : {$formatted_value} \n";
}

echo "\n";
echo "Weather\n";
echo "-------\n";
foreach ($data as $key => $value) {
    $formatted_key = match ($key) {
        'last_updated_epoch' => 'Last Updated (Epoch seconds)',
        default => ucwords(str_replace('_', ' ', $key))
    };
    $formatted_value = match ($key) {
        'temperature', 'feels_like' => "{$value}°C",
        'humidity' => "{$value}%",
        default => $value
    };
    echo " {$formatted_key} : {$formatted_value} \n";
}