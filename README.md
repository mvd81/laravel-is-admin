# Laravel Is Admin
[![Latest Version on Packagist](https://img.shields.io/packagist/v/mvd81/laravel-is-admin.svg?style=flat-square)](https://packagist.org/packages/mvd81/laravel-is-admin)
[![Build Status](https://travis-ci.com/mvd81/laravel-is-admin.svg?branch=master)](https://travis-ci.com/mvd81/laravel-is-admin)
## Introduction
Laravel package to extend your Laravel application with a simple admin permission functionality, with:

- Migration file to set a user as admin
- Middleware
- Blade directive
- Artisan command to see who is an admin
- Option to set user with ID 1 as super admin

## Requirements

Laravel 10 or higher

## Installation

1. ```composer require mvd81/laravel-is-admin```

2. Run
   ```php artisan migrate``` 
   to create the 'is_admin' column in the ```users``` table
   
3. Import the trait in the User model
```php
use Mvd81\LaravelIsAdmin\Traits\isAdmin;
```
4. Use the trait in the user model
```php
class User extends Authenticatable
{
    use isAdmin;
    ...
```

## How to use

You can set a 'normal' user as admin by setting the database column ```is_admin``` to ```1 ```, in database table ```users```.  

Or in the code

### Make admin
```php
$user = User::find(ID);
$user->makeAdmin(); 
```
### Undo admin
```php
$user = User::find(ID);
$user->undoAdmin(); 
```

## Super admin
It is possible to use user with ID 1 as admin without setting the 'is_admin' column to 1.  
First you need to publish the config file.

* ```php artisan vendor:publish```
* Choose the option: Provider: Mvd81\LaravelIsAdmin\LaravelIsAdminServiceProvider

Now in ```config/is_admin.php``` set 'use_super_admin' to true.

```php
'use_super_admin' => true,
```

## Middleware
There is a ```IsAdmin``` middleware to use in your routes.

Example: 
```php
Route::get('admin-page')->middleware('IsAdmin'); 
```

## Blade directive
Partial template/layout in your Blade view files only for admins?  
You can use this Blade directive
```blade
@isAdmin()
    I am an admin
@endisAdmin
```

## Who is an admin?
You can enter an artisan command to see how is an admin.
```bash
php artisan command:isAdmin
```

## Uninstall
1. ```composer remove mvd81/laravel-is-admin```
2. Remove the config file ```config/is_admin.php```
3. Remove the database ```is_admin``` column in table ```users```
4. If you used the blade ```@isAdmin()``` directive, remove them
5. Remove the ```is_admin``` middleware from your routes

