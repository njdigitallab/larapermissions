<?php

namespace NjDigitalLab\LaraPermissions\Contracts;

interface HasAuthUserPermissions
{
    /**
     * Get the authenticated user permissions.
     */
    public function getAuthUserPermissions(): array;
}
