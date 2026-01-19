<?php

use Dotenv\Dotenv;
use Mystic\WeatherApp\WeatherService;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

/**
 * Call code here
 */

if ($argc < 2) {
    echo "Usage: php weather.php <city>\n";
    echo "Example: php weather.php Lahore\n";
    exit(0);
}

$weatherService = WeatherService::create();
$city = $argv[1];

echo "Getting weather for $city...\n";
$weather = $weatherService->getCurrentWeather($city);

if ($weather['status']['code'] != 200) {
    echo "Error occurred while fetching weather for $city" . "\n";
    echo $weather['status']['message'] . "\n";
    exit(1);
}

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
        default => ucwords(str_replace('_', ' ', $key))
    };

    $formatted_value = match ($key) {
        'lat', 'lon' => "{$value}°",
        default => $value
    };

    printf(" %-30s : %s\n", $formatted_key, $formatted_value);
}

echo "\n";
echo "🌡  Weather\n";
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
    printf(" %-30s : %s\n", $formatted_key, $formatted_value);
}