# Module Manager & Generator


This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Installation

You need to publish the config file and the module stub files. You can do this by running the following command:

```php
php artisan vendor:publish --tag=laravel-module-manager
```


## Usage

To create a project use the following command, you have repalce the `MODULE_NAME` with the name of the module. 

```php
php artisan module:build MODULE_NAME
```

You may want to use ` --force` option to overwrite the existing module. if you use this option, it will replace all the exisitng files with the defalut stub files.


```php
php artisan module:build MODULE_NAME --force
```

### Testing

```bash
composer test
```

