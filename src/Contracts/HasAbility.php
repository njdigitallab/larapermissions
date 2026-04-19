<?php

namespace NjDigitalLab\LaraPermissions\Contracts;

interface HasAbility
{
    /**
     * Validate the user ability.
     */
    public function hasAbility(string $ability): bool;

    /**
     * Get the permissions class name.
     */
    public function getPermissionsClassName(): string;
}
