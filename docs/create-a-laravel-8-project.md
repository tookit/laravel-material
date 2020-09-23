## Why I create this repo

From my previous open source project [Vue material admin] (https://github.com/tookit/vue-material-admin), I'm considering to create a real world REST API
to show how to integrate with the admin dashboard template with [Vuex], and hope it can help someone who like `laravel`/`vue`/`vuetifyjs`/`google material design. Let's do it

## Env requirement
- Laravel 8
- php 7.4
- mysql 5.7


# Init Project

``` bash
composer create-project laravel/laravel vma-api

```

# Create database `vma` and update env
```
    create database vma
```

# Add some awesome package 

- tymon/jwt-auth (JWT authenticate)
- spatie/laravel-permission (ACL/Access control)
- spatie/laravel-query-builder( Build generic api query)
- spatie/laravel-valuestore (for general setting)

``` bash
composer require tymon/jwt-auth
composer require spatie/laravel-permission
composer require spatie/laravel-query-builder
composer require spatie/laravel-valuestore

```

## configure package

```bash
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan vendor:publish --provider="Spatie\QueryBuilder\QueryBuilderServiceProvider"

```

## Generate application key and jwt secret

```bash
    php artisan key:generate
    php artisan jwt:secret
```
