## A REST API  for [Vue material admin] (http://vma.isocked.com), base on laravel 8

## Why I create this ?
From my previous open source project [Vue material admin] (https://github.com/tookit/vue-material-admin), I'm considering to create a real world REST API
to show how to integrate with the admin dashboard template with [Vuex], and hope it can help someone who like `laravel`/`vue`/`vuetifyjs`/`google material design. Let's do it

## Ready to experience it

A [Demo API](http://demo.isocked.com/api) is ready

## Env requirement
- Laravel 8
- php 7.4
- mysql 5.7

For the detail to how to setup a laravel8 development, please check [https://laravel.com/docs/8.x/installation] (https://laravel.com/docs/8.x/installation), personally i'm using [laradock](https://laradock.io/documentation/)


## How to setup?


### composer install
```bash
composer install
```
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

### modify the env by your need, such as database connection, app key, jwt secret


### enjoy it

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Reference


