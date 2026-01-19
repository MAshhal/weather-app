# Weather App

A simple PHP command-line application that fetches and displays current weather information for a specified city
using [WeatherAPI.com](https://www.weatherapi.com/).

This project was built as part of learning
Laravel's [PHP Fundamentals course](https://laravel.com/learn/php-fundamentals).

> [!NOTE]
> I deviated slightly from the course approach by exploring more functionalities and using a different API than in the
> course.
> - **Modern PHP 8.x Features**: used `match` expressions, constructor property promotion, readonly properties, and
    named arguments.
> - **External Dependencies**: used `phpdotenv` for secure environment variable management.
> - **Object-Oriented Design**: used a static factory pattern for `WeatherService`.
> - **Enhanced API Integration**: switched to [WeatherAPI.com](https://www.weatherapi.com/) to support diverse search
    queries (City, Lat/Long, ZIP) and easier to implement.
> - **Error Handling**: implemented some (maybe a bit flaky :P) exception handling because something's better than
    nothing.

## Requirements

- PHP 8.1 or higher
- [Composer](https://getcomposer.org/)
- A WeatherAPI.com API key

## Setup

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd weather-app
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Configure environment variables:**
   Copy the example environment file and add your API key:
   ```bash
   cp .env.example .env
   ```
   Edit `.env` and set your `WEATHER_API_KEY`:
   ```env
   WEATHER_API_KEY="your_api_key_here"
   WEATHER_API_BASE_URL="https://api.weatherapi.com/v1/"
   ```

## Usage

Run the `weather.php` script from the command line, providing a query as an argument:

```bash
php weather.php <query>
```

### Supported Queries

- **City Name**: `php weather.php "London"`
- **Latitude and Longitude**: `php weather.php "48.8567,2.3508"`
- **ZIP/Postcode (UK/US/Canada)**: `php weather.php "90210"`

### Example Output

```text
Getting weather for London...

Location
--------
 City                           : London
 Region                         : City of London, Greater London
 Country                        : United Kingdom
 Latitude                       : 51.52°
 Longitude                      : -0.11°
 Timezone                       : Europe/London
 Local Time                     : 2024-01-19 09:00

🌡  Weather
-------
 Temperature                    : 5°C
 Feels Like                     : 2°C
 Condition                      : Partly cloudy
 Humidity                       : 81%
 Wind Direction                 : NW
 Last Updated                   : 2024-01-19 08:45
 Last Updated (Epoch seconds)   : 1705653900
```

## Project Structure

- `weather.php`: The main entry point for the CLI application.
- `src/WeatherService.php`: Contains the core logic for interacting with the Weather API.
- `composer.json`: Project dependencies and autoloading configuration.
- `.env`: Environment-specific configuration (created from `.env.example`).

## Environment Variables

| Variable               | Description                   | Default                          |
|------------------------|-------------------------------|----------------------------------|
| `WEATHER_API_KEY`      | Your WeatherAPI.com API key.  | None                             |
| `WEATHER_API_BASE_URL` | Base URL for the Weather API. | `https://api.weatherapi.com/v1/` |