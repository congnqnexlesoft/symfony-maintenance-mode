# Symfony maintenance mode
- The module is built upon the `https://github.com/rdehnhardt/lumen-maintenance-mode` package and customized for `Symfony 4.4` and `PHP 7.2`

## How to install
```shell
composer require congnqnexlesoft/symfony-maintenance-mode
```

Todo update

## How to configure
In `bootstrap/app.php`, add this instruction in providers

```PHP
$app->register(CongnqNexlesoft\MaintenanceMode\Providers\MaintenanceModeServiceProvider::class);
```
## Response
### Using JSON
- Require config the line below to your `.env` file
```dotenv
## congnqnexlesoft/lumen-maintenance-mode ##
MAINTENANCE_RESPONSE_FORMAT=json
```
### Using View
- Copy these files to your project:
```
resources/views/errors/503.blade.php
storage/framework/.gitignore
```

## Put the application into maintenance mode.

```shell
php artisan down
```

## Bring the application out of maintenance mode.

```shell
php artisan up
```

## IP released for access

In `.env` file

```dotenv
ALLOWED_IPS=999.99.9.999,999.99.9.999,999.99.9.999
```

---

## DevOps
### Release a new version
```shell
sh .ops/release-a-new-version.sh
```
