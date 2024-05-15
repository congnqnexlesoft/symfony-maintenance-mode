# Symfony maintenance mode
- The module is built upon the `https://github.com/rdehnhardt/lumen-maintenance-mode` package and customized for `Symfony 4.4` and `PHP 7.2`

## How to install
```shell
composer require congnqnexlesoft/symfony-maintenance-mode
```

## How to configure
In `config/services.yaml`, add this instruction in services providers

```yaml
    # [BEGIN] congnqnexlesoft/lumen-maintenance-mode
    CongnqNexlesoft\MaintenanceMode\ConsoleCommand\MaintenanceMode\DownCommand:
      class: CongnqNexlesoft\MaintenanceMode\ConsoleCommand\MaintenanceMode\DownCommand
      tags: [ 'console.command' ]
    CongnqNexlesoft\MaintenanceMode\ConsoleCommand\MaintenanceMode\UpCommand:
      class: CongnqNexlesoft\MaintenanceMode\ConsoleCommand\MaintenanceMode\UpCommand
      tags: [ 'console.command' ]
    CongnqNexlesoft\MaintenanceMode\MaintenanceModeService:
      autowire: true
    CongnqNexlesoft\MaintenanceMode\Http\Middleware\MaintenanceModeMiddleware:
      class: CongnqNexlesoft\MaintenanceMode\Http\Middleware\MaintenanceModeMiddleware
      arguments:
        - '@CongnqNexlesoft\MaintenanceMode\MaintenanceModeService'
      tags:
        - { name: kernel.event_listener, event: kernel.request, method: onRequest }
    # [END] congnqnexlesoft/lumen-maintenance-mode
```
## Response
### Using JSON
- Require config the line below to your `.env` file
```dotenv
## congnqnexlesoft/lumen-maintenance-mode ##
MAINTENANCE_RESPONSE_FORMAT=json
```
### Copy these files to your project (if):
```
public/.gitignore
```

## Put the application into maintenance mode (Symfony)
```shell
php bin/console down
```

## Bring the application out of maintenance mode (Symfony)
```shell
php bin/console up
```

---
## DevOps
### Release a new version
```shell
sh .ops/release-a-new-version.sh
```
