# Binance Ticker Manager

**Binance Ticker Manager** is a PHP application for fetching, caching, and displaying cryptocurrency ticker data. The application uses PHP-FPM and Nginx within Docker containers for development and deployment.

## Project Structure

- `docker-compose.yml`: Docker Compose configuration file to define and run multi-container Docker applications.
- `nginx/default.conf`: Nginx configuration file to set up the server and reverse proxy for PHP-FPM.
- `src/`: Contains the PHP source code.
  - `Controllers/`: Contains the `CurrencyController.php` file for handling business logic.
  - `Models/`: Contains the `CurrencyDataParser.php` and `CurrencyPair.php` files for data parsing and model representation.
  - `Services/`: Contains the `CurrencyDataFetcher.php` for fetching currency data from the API and `FileManager.php` for managing file operations.
  - `css/`: Contains CSS files, including Bootstrap for styling.
  - `data.json`: JSON file used for caching currency data.
  - `index.php`: Entry point of the PHP application.

## Requirements

- Docker
- Docker Compose

## Explanation

1. **`docker-compose.yml`**:
   - Defines two services: `web` (Nginx) and `php-fpm`.
   - Maps ports, volumes, and links the services.

2. **`nginx/default.conf`**:
   - Nginx configuration for serving the PHP application.

3. **Build and Start**:
   - Instructions to build and start the Docker containers using `docker-compose`.

## Getting Started

### 1. Clone the Repository

Clone the repository to your local machine:

```sh
git clone https://github.com/mikfilldev/binance-ticker-manager.git
cd binance-ticker-manager
```

### 2. Run with docker compose


```sh
docker-compose up -d
```

### 3. Access the web page

Once the containers are up and running, you can access the web application by navigating to:

[http://localhost:8080](http://localhost:8080)

Updating Data
The application fetches the latest ticker data from Binance and caches it in data.json. The data is updated automatically if the cache is older than 10 minutes.