# SPA Application with Vue.js and Laravel

This is a Single Page Application (SPA) built with Vue.js integrated into a Laravel backend. Follow the instructions below to set up and run the application.

## Prerequisites

Before you begin, ensure you have the following prerequisites installed:

- [Node.js and npm](https://nodejs.org/): Install Node.js and npm on your system.

- [Composer](https://getcomposer.org/): Install Composer, a dependency manager for PHP.

- [PHP](https://www.php.net/): Ensure PHP is installed on your system.

- [MySQL](https://www.mysql.com/) : Set up a MySQL database for the Laravel backend.

## Clone the Repository

Clone the project repository using Git:

```bash
git clone https://github.com/nazarskrinskyi/Spa-App.git
```


## Laravel Backend Setup

Copy the .env.example file to .env and configure the database connection.

run migrations and seed the database if needed:


    cp .env.example .env
    php artisan migrate

## Vue.js Frontend Setup

Navigation to the frontend directory:

    resources/js
Install Vue.js, Vue Router, Laravel Mix, and Webpack:
```bash
npm install vue vue-router laravel-mix webpack --save-dev
```

## Docker
run docker
```bash
docker-composer up -d
```
docker dependency installation:
```bash
docker exec -it spa_app bash
```
```bash
npm install --save vue@next && npm install --save-dev vue-loader@next
```
```bash
 npm install vue-router
```
```bash
 npm install 
```
```bash
npm install vue-client-recaptcha --save
```
```bash
npm install lightbox2 --save
```
```bash
npm install primevue 
```
```bash
composer require predis/predis
```
```bash
npm install vuejs-paginate-next --save
```
