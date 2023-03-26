<br />
<br />
<p align="center">
  <!-- XMAS: https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg-->
<img width="589" src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" alt="Laravel">
</p>
<br />




# Requirements

- PHP ^8.1
- Composer ^2.0
# Installation

Clone the project

```bash
  git clone {repository link} app-name
```

Go to the project directory

```bash
  cd app-name
```

Checkout `main` branch

```bash
  git checkout main
```



Install dependencies

```bash
  composer install
```

Setup .env file
- Laravel Sail
```bash
  cp .env.sail .env
```
- Local development environment:
```bash
  cp .env.example .env
```

Generate application key

```bash
  php artisan key:generate 
```
Generate passport

```bash
  php artisan passport:install
```

create DB and seed

```bash
  php artisan migrate --seed
```

Generate scripe api docs

```bash
  php artisan scribe:generate
```
and open {URL}/docs
## Run with Laravel Sail

If you are new to docker, it is not a problem because using [**Laravel Sail**](https://laravel.com/docs/9.x/sail#introduction) we don't have to go deeply into docker.
All you need to know about **Sail** is mentioned in the [Laravel installation instructions using sail](https://laravel.com/docs/9.x/installation#laravel-and-docker) and the [Sail documentation](https://laravel.com/docs/9.x/sail#).
- Docker installation:

    - **Windows**: you can follow this [tutorial](https://www.youtube.com/watch?v=rr6AngDpgnM) to learn how run Laravel project using Sail. and in case you want to run multiple Laravel  projects at the same time, you can also watch this [tutorial](https://www.youtube.com/watch?v=N3uVU7To2Bc) (note that there is a written version of these tutorials you can find it in the videos description).
    - **Linux**: you can read these [instructions](https://docs.docker.com/engine/install/ubuntu/) for installing the docker. and in case you want to run multiple Laravel  projects at the same time, you can use the same windows instructions mentioned in this [tutorial](https://www.youtube.com/watch?v=N3uVU7To2Bc).
- Sail basic commands:

    - Start the containers:
        ```bash
        ./vendor/bin/sail up -d
        ```

    - Open sail shell:
        ```bash
        ./vendor/bin/sail shell
        ```

    - Stop the containers:
        ```bash
        ./vendor/bin/sail stop
        ```

    - Stop the containers and remove them:
        ```bash
        ./vendor/bin/sail down
        ```

    - Stop the containers and remove them and delete volumes:
        ```bash
        ./vendor/bin/sail down -v
        ```

- Notes:
    - when working with Laravel Sail it is important to use [aliases](#aliases) to speed up your work.

    - your daily routine will only use `sail up -d` and `sail stop` but if you faced a problem you may need `sail down -v` and then start your containers again.

    - we defined only the `mysql`, `redis`, and `mailhog` images in the `docker-compose.yml` file because they are the most used, you can modify the images based on your project requirements.

    - after setting up every thing you can run `{php or sail} artisan migrate --seed` and `(php or sail) artisan passport:install`.
## Run Locally

You can use your typical development environment but it is recommended to use [Laravel Sail](https://laravel.com/docs/9.x/sail#introduction).
- Start local development server:

    ```bash
    php artisan serve
    ```

# Installed Packages

We installed these packages because most of the web applications we are going to build require these package concepts.

General packages:
- [Enlightn security consultant](https://github.com/enlightn/enlightn)
- [Passport](https://laravel.com/docs/9.x/passport)
- [Laravel Actions](https://laravelactions.com)
- [Laravel Data](https://spatie.be/docs/laravel-data/v2/introduction)
- [Laravel Model States](https://spatie.be/docs/laravel-model-states/v2/01-introduction)
- [Laravel Permissions](https://spatie.be/docs/laravel-permission/v5/introduction)

Development only packages:
- [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper)
- [Scribe API documentation tool](https://scribe.knuckles.wtf/laravel)
- [Laravel Telescope](https://laravel.com/docs/9.x/telescope)
- [Pest Testing Framework](https://pestphp.com/)
- [PHP Metrics](https://www.phpmetrics.org/)
- [Grum PHP](https://github.com/phpro/grumphp)
- [Security Advisor](https://github.com/Roave/SecurityAdvisories)

# Features

- [DDD (domain driven design)](#ddd)
- [API Response Helper](#api-response-helper)
- [Scribe Custom Tags](#scribe-custom-tags)
- [Global Helper](#global-helper)
- [Migration Structure](#migration-structure)
- [Polymorphic Mapping](#polymorphic-mapping)
- [Database Seeders](#database-seeders)
- [Permissions and Roles Seeding](#permissions-and-roles-seeding)
## DDD

This structure is inspired by [LARAVEL BEYOND CRUD](https://laravel-beyond-crud.com/).

You can read these articles at first to have an initial understanding of the DDD:

-   [Domain Oriented Laravel](https://stitcher.io/blog.laravel-beyond-crud-01-domain-oriented-laravel)
-   [Working With Data](https://stitcher.io/blog/laravel-beyond-crud-02-working-with-data)
-   [Actions](https://stitcher.io/blog/laravel-beyond-crud-03-actions)
-   [Models](https://stitcher.io/blog/laravel-beyond-crud-04-models)
-   [States](https://stitcher.io/blog/laravel-beyond-crud-05-states)
-   [Managing Domains](https://stitcher.io/blog/laravel-beyond-crud-06-managing-domains)
-   [Application Layer](https://stitcher.io/blog/laravel-beyond-crud-07-entering-the-application-layer)
-   [View Models](https://stitcher.io/blog/laravel-beyond-crud-08-view-models)
-   [Test Factories](https://stitcher.io/blog/laravel-beyond-crud-09-test-factories)

When you open the boilerplate, you will find a similar structure to the one mentioned in the articles, also we will be presenting a lecture to help you gain a better understanding.
## API Response Helper
A simple trait allowing for consistent API responses throughout your Laravel application.
- Usage: Simply reference the required trait within your controller.
```php
<?php

namespace App\Http\Api\Controllers;

use App\Traits\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use App\Http\Controller;

class ProductController extends Controller
{
    use ApiResponseHelper;

    public function index(): JsonResponse
    {
        return $this->okResponse();
    }
}
```
- You can see all the available methods in `App\Traits\ApiResponseHelpers.php`
## Scribe Custom Tags
Additional scribe tags that matches the ApiResponseHelper responses.
```php
<?php

namespace App\Http\Api\Controllers;

use App\Helpers\ApiController;
use App\Traits\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use App\Http\Controller;

/**
 * Class CategoryController
 * @group Category
 */
class CategoryController extends Controller
{
    use ApiResponseHelper;

    /**
     * Get Categories
     *
     * this request is used to get all categories.
     *
     * @queryParam filter[name]
     *
     * @okFile responses/api/success/Category/category_paginated.json
     * @usesPagination
     * @failedResponse
     * @forbiddenResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     */
    public function index(): Response
    {
        return CategoryResource::collection($categories->all());
    }

}
```
### Response tags:
| Tag | Status |
| :-------- | :------- |
| `@failedResponse`| `400` |
| `@forbiddenResponse`| `403` |
| `@notFoundResponse`| `404` |
| `@okResponse`| `200` |
| `@serverErrorResponse`| `500` |
| `@unauthorizedResponse`| `401` |
| `@unprocessableResponse`| `422` |

### General tags:
| Tag | Description |
| :-------- | :------- | 
| `@okFile {responses/success/{Controller subject}/{endpoint subject}.json}`| will add JSON file content response with status 200|
| `@usesPagination`| will add `page[number]` and `page[size]` to the query parameters|

- Note: you should put your saved JSON response files in ./storage/responses/success/{Controller subject}/{endpoint subject}.json
- Example: `@okFile responses/success/Product/product_paginated.json`
## Global Helper

Simple composer autoloaded php file, that we can use for writing helper functions inside it.

You can find this file in `./src/shared/Helpers/global.php`.

Feel free to define new helper files based on your needs to keep your helper files readable and maintainable.

**Note:** you can define helper file in your app folder if you have functions that is **only** going to be used on your application.
## Migration Structure

In order to group your migration files by their domains, you can add additional migration directories in `AppServiceProvider` using `loadMigrationsFrom` function:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom([
            database_path().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR.'Client',
        ]);
    }
}
```
## Polymorphic Mapping

Please read this [article](https://laravel-news.com/enforcing-morph-maps-in-laravel) first to identify the problem.

In order to achieve the morph mapping, first you have to add the model key to `MorphEnum` and then use it in `Relation::morphMap` function as shown in the example:


```php
<?php

namespace Shared\Enums;

enum MorphEnum: string
{
    case USER = 'user';
}
```


```php
<?php

namespace App\Providers;

use Shared\Enums\MorphEnum;
use Domain\Client\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Relation::morphMap([
            MorphEnum::USER->value => User::class,
        ]);
    }
}
```
## Database Seeders

We generally have two types of seeded data:
- Initial data: the project cannot function without it. For example, countries table data, and these data usually come from datasets.
- Fake data: for testing purposes that can fill up any table instead of manually inserting row by row, this data is usually generated by factories.

In order to prevent the fake data from being seeded in the production environment, we created a new seeder class called `TestingSeeder.php` which will contain all the fake data seeders and will only run in a non-production environment. The normal seeders will stay in `DatabaseSeeder.php`. 
## Permissions and Roles Seeding

To keep your development experience easy, we created two enums, `Shared\Enums\Client\PermissionEnum.php` for defining your application permissions and `Shared\Enums\Client\RoleEnum.php` for defining roles and their permissions.

You can map each role permissions using this function in `RoleEnum`:
```php
    public static function getRolesPermissions(): array
    {
        return [
            self::ADMIN->value => [
                PermissionEnum::MODEL_MANAGE->value,
            ],
        ];
    }
```

All you need to do is fill up these enums, and their data will be automatically seeded to the database using `PermissionSeeder.php`.

By default we are seeding the permissions and roles for the `api` and the `web` guards, if you need to update them you can do that in the `permission.seeded_guards` config
# Recommendations

- [VS Code extensions](#vs-code-extensions)
- [General Resources](#general-resources)
- [Sail Xdebug Configurations](#sail-xdebug-configurations-on-vs-code)

## VS Code extensions

In the root directory you will find `vsc-extensions.txt` file, which contains the recommended set of extensions to install for developing Laravel projects. to install them, you need to install this [extension](https://marketplace.visualstudio.com/items?itemName=aslamanver.vsc-export) first and then execute the `VSC Extensions Import` command.
## General Resources

- Youtube channels:
    -   [Laravel Daily](https://www.youtube.com/@LaravelDaily)
    -   [Laracon EU](https://www.youtube.com/@LaraconEU)
    -   [Laracasts](https://www.youtube.com/@Laracastsofficial)
    -   [Beyond Code](https://www.youtube.com/@beyondcode2692)
    -   [Laravel](https://www.youtube.com/@LaravelPHP)
    -   [Free Code Camp](https://www.youtube.com/@freecodecamp)
    -   [PHP Barcelona](https://www.youtube.com/@phpbarcelona9352)
    -   [Code course](https://www.youtube.com/@codecourse)
    -   [Program With Gio](https://www.youtube.com/@ProgramWithGio)
    -   [Mohamed Said](https://www.youtube.com/@themsaid)
    -   [PHP Annotated](https://www.youtube.com/@phpannotated)
    -   [Laratips](https://www.youtube.com/@Laratips)
    -   [Andrew Schmelyun](https://www.youtube.com/@aschmelyun)
- Websites:
    -   [Laravel Documentation](https://laravel.com/docs)
    -   [Laracasts](https://laracasts.com/)
    -   [Laravel Magazine](https://laravelmagazine.com)
    -   [Made With Laravel](https://madewithlaravel.com)
    -   [Laravel Daily](https://laraveldaily.com)
    -   [Laravel Spatie Guidelines](https://spatie.be/guidelines/laravel-php)
    -   [Laravel News](https://laravel-news.com)
    -   [Stitcher](https://stitcher.io/)
## Sail Xdebug Configurations on VS Code
[Xdebug](https://xdebug.org) is an extension for PHP, and provides a range of features to improve the PHP development experience.

If you want to use Xdebug on Laravel Sail you can use the following settings in ./.vscode/launch.json, and you need to make sure that `SAIL_XDEBUG_MODE` is set in your .env file to `develop,debug,coverage` when you built your sail containers, or you can set it and rebuild your container again.

```json
{
    // Use IntelliSense to learn about possible attributes.
    // Hover to view descriptions of existing attributes.
    // For more information, visit: https://go.microsoft.com/fwlink/?linkid=830387
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for Sail Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "/var/www/html": "${workspaceFolder}"
            },
            "hostname": "localhost",
            "ignore": ["**/vendor/**/*.php"],
            "xdebugSettings": {
                "max_data": 65536,
                "show_hidden": 1,
                "max_children": 100,
                "max_depth": 3
            }
        },
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003
        },
        {
            "name": "Launch currently open script",
            "type": "php",
            "request": "launch",
            "program": "${file}",
            "cwd": "${fileDirname}",
            "port": 0,
            "runtimeArgs": [
                "-dxdebug.start_with_request=yes"
            ],
            "env": {
                "XDEBUG_MODE": "debug,develop",
                "XDEBUG_CONFIG": "client_port=${port}"
            }
        },
        {
            "name": "Launch Built-in web server",
            "type": "php",
            "request": "launch",

           "runtimeArgs": [
                "-dxdebug.mode=debug",
                "-dxdebug.start_with_request=yes",
                "-S",
                "localhost:0"
            ],
            "program": "",
            "cwd": "${workspaceRoot}",
            "port": 9003,
            "serverReadyAction": {
                "pattern": "Development Server \\(http://localhost:([0-9]+)\\) started",
                "uriFormat": "http://localhost:%s",
                "action": "openExternally"
            }
        }
    ]
}
```


