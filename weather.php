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
$weather = $weatherService->getCurrentWeather($city);

var_dump($weather);