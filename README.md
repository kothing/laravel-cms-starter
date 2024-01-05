# CMS-laravel-starter

A modular CMS starter  application built with Laravel 10.x.

`Laravel Starter` is a simple starter CMS based on Laravel 10.x. Most of the commonly needed features of an application like `Authentication`, `Authorisation`, `User` and `Role management`, `Application Backend`, `Backup`, `Log viewer` are available here. It is modular, so you may use this project as a base and build your own modules. A module can be used in any `Laravel Starter` based projects.

**Screenshots**   

![preview Image](/public/img/preview-image-01.png)

![preview Image](/public/img/preview-image-02.png)

![preview Image](/public/img/preview-image-03.png)

## Core Features

- User Authentication
<!-- * Social Login
  * Google
  * Facebook
  * Github
  * Build in a way adding more is much easy now -->
- User Profile with Avatar
  - Separate User Profile table
- Role-Permissions for Users
- Dynamic Menu System
- Language Switcher
- Localization enabled across the project
- Backend Theme
  - Bootstrap 5, CoreUI
  - Fontawesome 6
- Frontend Theme
  - Tailwind
  - Fontawesome 6
- Page Module
- Article Module
  - Posts
  - Categories
  - Tags
  - Comments
  - wysiwyg editor
  - File browser
- Application Settings
- External Libraries
  - Bootstrap 5
  - Fontawesome 6
  - CoreUI
  - Tailwind
  - Datatables
  - Select2
  - Date Time Picker
- Backup (Source, Files, Database as Zip)
- Log Viewer
- Notification
  - Dashboard and details view

# How to start

## Server Requirements

- PHP >= 8.1
- Mysql >= 5.7.8
- BCMath PHP Extension
- Ctype PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Web UI Installation

This `laravel-cms-stater` allows users who don't use Composer, SSH etc to install your application just by following the setup wizard. The current features are :

- Check For Server Requirements.
- Check For Folders Permissions.
- Ability to set database information.
  - env text editor
  - env form wizard
- Migrate The Database.
- Seed The Tables.

1. Clone or download the repository
2. Go to the project directory and run `composer install`
3. visit `http://your-site.domain/install`

## Classic Installation

Follow the steps mentioned below to install and run the project. You may find more details about the installation in [Installation Wiki](https://github.com/kothing/laravel-cms-starter/wiki/installation).

1. Clone or download the repository
2. Go to the project directory and run `composer install`
3. Create `.env` file by copying the `.env.example`. You may use the command to do that `cp .env.example .env`
4. Update the database name and credentials in `.env` file
5. Run the command to generate application key `php artisan key:generate`
6. Run the command `php artisan migrate --seed`
7. Link storage directory: `php artisan storage:link`
8. You may create a virtualhost entry to access the application or run `php artisan serve` from the project root and visit `http://127.0.0.1:8000`

_After creating the new permissions use the following commands to update cashed permissions._

`php artisan cache:forget spatie.permission.cache`

## Docker and Laravel Sail

This project is configured with Laravel Sail (https://laravel.com/docs/sail). You can use all the docker functionalities here. To install using docker and sail:

1. Clone or download the repository
2. Go to the project directory and run `composer install`
3. Create `.env` file by copying the `.env-sail`. You may use the command to do that `cp .env-sail .env`
4. Update the database name and credentials in `.env` file
5. Run the command `sail up` (consider adding this to your alias: `alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'`)
6. Run the command `sail artisan migrate --seed`
7. Link storage directory: `sail artisan storage:link`
8. Since Sail is already up, you can just visit http://localhost:80

## Icons

FontAwesome & CoreUI Icons, two different font icon library is installed for the Backend theme and only FontAwesome for the Frontend. For both of the cases, we used the free version. You may install the pro version separately for your project.

- **FontAwesome** - https://fontawesome.com

## admin dashborad login

Login Now by giving this data `http://your-site-domain.com/admin`

```php
Username: super@admin.com
Password: password

Username: admin@admin.com
Password: password

Username: manager@manager.com
Password: password

Username: executive@executive.com
Password: password

Username: user@user.com
Password: password
```

You can find it in `database/seeders/Auth/UserTableSeeder.php`

## Role - Permissions

Several custom commands are available to add and update `role-permissions`. Please read the [Role - Permission Wiki page](https://github.com/kothing/laravel-cms-starter/wiki/role-permission), where you will find the list of commands with examples.

# Demo Data

If you want to test the application on your local machine with additional demo data you may use the following command.

```php
php artisan starter:insert-demo-data --fresh
```

There are options to truncate the `posts, categories, tags, and comments` tables and insert new demo data.

`--fresh` option will truncate the tables, without this command new set of data will be inserted.

```php

php artisan starter:insert-demo-data --fresh

```

# Custom Commands

We have created a number of custom commands for the project. The commands are listed below with a brief about their use of it.

## Clear All Cache

```bash
composer clear-all
```

this is a shortcut command clear all cache including config, route, and more

## Code Style Fix

We are now using `Laravel Pint` to make the code style stays clean and consistent as the Laravel Framework. Use the following command to apply CS-Fix.

```bash
composer pint
```

# Module Manager & Generator

## Create New module

To create a project use the following command, you have repalce the MODULE_NAME with the name of the module.

```php
php artisan module:build MODULE_NAME
```

You may want to use --force option to overwrite the existing module. if you use this option, it will replace all the exisitng files with the defalut stub files.

```php
php artisan module:build MODULE_NAME --force
```

_After creating the new moudle use the following commands to to run your database migrations._

```php
php artisan migrate
```

## Testing

```php
composer test
```
