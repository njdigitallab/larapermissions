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
        $ability = Str::snake($ability);
        $class = $this->getPermissionsClassName();

        $list = $class::getPermissionsList();

        if (! array_key_exists($ability, $list)) {
            return true;
        }

        $permissions = $list[$ability];

        if (empty($permissions)) {
            return true;
        }

        return count(array_intersect($permissions, $this->getAuthUserPermissions())) >= 1;
    }
}
