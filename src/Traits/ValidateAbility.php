<?php

namespace NjDigitalLab\LaraPermissions\Traits;

use Illuminate\Support\Str;

Trait ValidateAbility
{
    /**
     * Validate the user ability.
     */
    public function hasAbility(string $ability): bool
    {
        $class = $this->getPermissionsClassName();
        $method = 'get'.Str::studly($ability).'Permissions';

        if (! method_exists($class, $method)) {
            return false;
        }

        $permissions = $class::$method();

        if (empty($permissions)) {
            return true;
        }

        return count(array_intersect($permissions, $this->getAuthUserPermissions())) >= 1;
    }
}
