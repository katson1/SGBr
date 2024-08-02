# Simple Places CRUD

A simple CRUD application for managing places using Laravel 10, PHP 8.2, and Docker.

## Requisites

Before starting, make sure your development environment meets the following requirements:

- [PHP](https://www.php.net/downloads.php) >= 8.2
- [Composer](https://getcomposer.org/)
- [Docker](https://www.docker.com/get-started/)

## Installation and Configuration

Clone the project:
```bash
git clone https://github.com/katson1/SGBr.git
```

Navigate to the project folder and install the necessary dependencies with Composer:
```bash
cd SGBr
composer install
```
### Configuration with Docker
To set up and start the project using Docker, run the following commands.

> This process may take some time as it will need to download Docker images.

```bash
cp .env.example .env
php artisan key:generate
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```

## Testing
Use the following command to run automated tests:
```bash
docker-compose exec app php artisan test
```

## Author
<div align="left">
  <div>
    Katson Matheus
    <a href="https://github.com/katson1">
      <img src="https://skillicons.dev/icons?i=github" alt="html" height="15" />
    </a>
    <a href="https://discordapp.com/users/210789016675549184">
      <img src="https://skillicons.dev/icons?i=discord" alt="html" height="15"/>
    </a>
    <a href="https://www.linkedin.com/in/katsonmatheus/">
      <img src="https://skillicons.dev/icons?i=linkedin" alt="html" height="15"/>
    </a>
    <a href="mailto:katson.alves@ccc.ufcg.edu.br">
      <img src="https://skillicons.dev/icons?i=gmail" alt="html" height="15"/>
    </a>
  </div>
</div>