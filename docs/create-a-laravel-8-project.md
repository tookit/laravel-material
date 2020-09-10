# Init Project

``` bash
composer create-project laravel/laravel vma-api

```

# Create database vma and update env


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
