# CARDZ

An attempt to style generic Bonus Cards API  with the DDD approach using Laravel.

There are some stipulations we're trying to uphold:
 - isolate the project code from the Laravel framework as much as possible;
 - construct a modular monolith in such a way to make future transition to microservices relatively painless;
 - try to use at least some major strategic and tactic DDD patterns;
 - try to keep code complexity under control;
 - try to use CQRS, ES and ABAC Auth as a demonstration, but keep them contained;
 - provide the bare minimum of tests required to keep all future refactoring less error-prone.

## Installation instructions

- `git clone` [repo](https://github.com/IndomitablePlatypus/cardz/)
- Ensure you have php of 8.0+ version.
- copy `.env.example` to `.env`
- Run `composer install`
- Provide your app key with `php artisan key:generate`
- Make sure you have your PostgreSQL installed and running. Create relevant database and provide credentials for the db connection in your .env file.
- Launch `php artisan serve` and proceed to the provided localhost page to take a look at the project API documentation.

Optionally you can run `php artisan tests` to take a look at a small assortment of included tests.

## Ubiquitous language
TBD

## Event storming diagram
TBD

## DDD Reference links
TBD

## OpenApi Reference links
- [RapiDoc](https://mrin9.github.io/RapiDoc/quickstart.html): wrap an OpenApi json. RapiDoc is licensed software of [mrin9](https://github.com/mrin9/RapiDoc).
- Laravel OpenApi generator: generate OpenApi json. https://vyuldashev.github.io/laravel-openapi/#installation
