# Simple Places CRUD

A simple CRUD application for managing places, built with Laravel 10, PHP 8.2, and Docker.

## Prerequisites

Ensure your development environment meets the following requirements before starting:

- [PHP](https://www.php.net/downloads.php) >= 8.2
- [Composer](https://getcomposer.org/)
- [Docker](https://www.docker.com/get-started/)

## Installation and Configuration

### Clone the Repository

Clone the project from GitHub:

```bash
git clone https://github.com/katson1/SGBr.git
```

### Install Dependencies

Navigate to the project directory and install the necessary dependencies using Composer:

```bash
cd SGBr
composer install
```

### Configuration with Docker

To set up and start the project using Docker, follow these steps:

1. Copy the example environment file and generate the application key:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

2. Build and start the Docker containers:

   ```bash
   docker-compose up --build -d
   ```
    > Note: This initial setup may take some time as it involves downloading Docker images.
   

3. Generate the application key and run migrations inside the Docker container:

   ```bash
   docker-compose exec app php artisan key:generate
   docker-compose exec app php artisan migrate
   ```

## Running Tests

To execute the automated tests, use the following command:

```bash
docker-compose exec app php artisan test
```

## Author

<div align="left">
  <div>
    Katson Matheus
    <a href="https://github.com/katson1">
      <img src="https://skillicons.dev/icons?i=github" alt="GitHub" height="15" />
    </a>
    <a href="https://discordapp.com/users/210789016675549184">
      <img src="https://skillicons.dev/icons?i=discord" alt="Discord" height="15"/>
    </a>
    <a href="https://www.linkedin.com/in/katsonmatheus/">
      <img src="https://skillicons.dev/icons?i=linkedin" alt="LinkedIn" height="15"/>
    </a>
    <a href="mailto:katson.alves@ccc.ufcg.edu.br">
      <img src="https://skillicons.dev/icons?i=gmail" alt="Email" height="15"/>
    </a>
  </div>
</div>
