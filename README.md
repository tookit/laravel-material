<p align="center">
  <a href="https://github.com/tookit/laravel-material" title="GitHub action"><img alt="GitHub Actions status" src="https://github.com/tookit/laravel-material/actions/workflows/laravel.yml/badge.svg"></a>
  <a href="https://github.com/tookit/laravel-material/blob/master/LICENSE" title="license"><img alt="LICENSE" src="https://img.shields.io/badge/license-MIT-428f7e.svg?logo=open%20source%20initiative&logoColor=white&labelColor=555555"></a>
</p>


## Laravel Material Admin Template

A laravel materil admin template 

## Components

- [BACKEND API](https://github.com/tookit/laravel-material)
- [Backend UI](https://github.com/tookit/laravel-material-admin)



## Features

- Module Based
- Access Controll
- API Explorer
- JWT Auth
- Multi Language


## Ready to experience it

[Demo](https://github.com/tookit/laravel-material)

## Env requirement
- Laravel 9
- php 8.0
- mysql 

For the detail to how to setup a laravel 8 development, please check [https://laravel.com/docs/8.x/installation] (https://laravel.com/docs/8.x/installation), personally i'm using [laradock](https://laradock.io/documentation/)


## How to setup?


### composer install
```bash
composer install
```


### modify the env by your need, such as database connection, app key, jwt secret


### create database
```
//mysql cli
create database vma

```
### create database schema and create a sample user

```bash
php artisan migrate
php artisan db:seed --class=UserSeeder

```



### enjoy it



## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Reference/Packages

- nwidart/laravel-modules
- spatie/eloquent-sortable
- spatie/eloquent-permission
- spatie/laravel-query-builder
- spatie/laravel-sluggable
- spatie/laravel-tags
- spatie/laravel-translatable
- spatie/laravel-valuestore
- codezero/laravel-unique-translation


