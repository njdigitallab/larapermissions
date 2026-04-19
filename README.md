# Lara Permissions

### About

Lara Permissions is a laravel package that allows you to integrate permissions into your application.

### Installation

Install with composer `composer require njdigitallab/larapermissions`.

### Setup

1) Publish the package migration via artisan commmand `php artisan vendor:publish --tag=larapermissions-migrations`.

2) Run the artisan command `php artisan migrate`.

3) Add the `NjDigitalLab\LaraPermissions\Traits\LaraPermissions` trait to your User model.

```php
<?php

namespace App\Models;

...
use NjDigitalLab\LaraPermissions\Traits\LaraPermissions;

class User extends Authenticatable
{
    use LaraPermissions;
}
```

### Getting Started

Create a policy with the artisan command `php artisan larapermissions:policy PostPolicy`.

This will create a `PostPolicy.php` file in your `App/Policies` directory and a `PostPermissions.php` file in your `App/Permissions` directory.

### Assigning Permissions to Users

`NjDigitalLab\LaraPermissions\PermissionsList::getPermissionsList()` will fetch the list of available permissions based on the Policies created.

For example, if you create a `PostPolicy.php` and `UserPolicy.php` file, the following permissions will be available:

```php
[
    'post' => ['post:create', 'post:update', 'post:trash', 'post:restore', 'post:destroy'],
    'user' => ['user:create', 'user:update', 'user:trash', 'user:restore', 'user:destroy'],
]
```

In your create/update view file, you can loop through the array and display the permissions and use checkboxes to select which permissions the user should have. The submitted permissions should be saved to the `permissions` attribute on the user model.

![Alt Text](./images/user-view.png)

### Policy Methods and Valid Permissions

```php
public function menu(Model $user): bool
// Must have at least one of the available permission.

public function viewList(Model $user): bool
// Must have either the update or trash permission

public function viewTrashList(Model $user): bool
// Must have either the restore or destroy permission

public function create(Model $user): bool
// Must have the create permission

public function view(Model $user, Model $model): bool
// Must have the update permission

public function update(Model $user, Model $model): bool
// Must have the update permission

public function trash(Model $user, Model $model): bool
// Must have the trash permission

public function restore(Model $user, Model $model): bool
// Must have the restore permission

public function destroy(Model $user, Model $model): bool
// Must have the destroy permission

public function performCreate(Model $user): bool
// Must have the create permission

public function performView(Model $user): bool
// Must have the update permission

public function performUpdate(Model $user): bool
// Must have the update permission

public function performTrash(Model $user): bool
// Must have the trash permission

public function performRestore(Model $user): bool
// Must have the restore permission

public function performDestroy(Model $user): bool
// Must have the destroy permission

public function performSearch(Model $user): bool
// Must have either of the update, trash, restore or destroy permission

public function performBulkRequest(Model $user): bool
// Must have either of the trash, restore or destroy permission
```

### Creating Super Admin

Run the artisan command `php artisan larapermissions:create-super-admin`.

The Super Admin will be able to perform any action.