<?php

namespace Mystic\WeatherApp;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class WeatherService
{
    private Client $client;
    private string $apiUrl;

    private function __construct(
        private readonly string $apiKey,
        private readonly string $baseUrl
    )
    {
        $this->client = new Client();
        $this->apiUrl = $this->baseUrl . 'current.json';
    }

    public static function create(
        ?string $apiKey = null,
        ?string $baseUrl = null,
    ): WeatherService
    {
        return new self(
            apiKey: $apiKey ?? $_ENV['WEATHER_API_KEY'],
            baseUrl: $baseUrl ?? $_ENV['WEATHER_API_BASE_URL']
        );
    }

    public function getCurrentWeather(string $city): array
    {
        try {
            $response = $this->client->get($this->apiUrl, [
                'query' => [
                    'key' => $this->apiKey,
                    'q' => $city,
                ]
            ]);
        } catch (GuzzleException $e) {
            return [
                'status' => [
                    'code' => $e->getCode() ?: 500,
                    'message' => $e->getMessage(),
                ],
            ];
        }

        $weatherData = json_decode($response->getBody()->getContents(), true);

        return [
            'status' => [
                'code' => $response->getStatusCode(),
                'message' => $response->getReasonPhrase(),
            ],
            'location' => $weatherData['location'],
            'data' => [
                'temperature' => $weatherData['current']['temp_c'],
                'feels_like' => $weatherData['current']['feelslike_c'],
                'condition' => $weatherData['current']['condition']['text'],
                'humidity' => $weatherData['current']['humidity'],
                'wind_direction' => $weatherData['current']['wind_dir'],
                'last_updated' => $weatherData['current']['last_updated'],
                'last_updated_epoch' => $weatherData['current']['last_updated_epoch'],
            ]
        ];
    }

}