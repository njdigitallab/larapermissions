<?php

namespace NjDigitalLab\LaraPermissions\Traits;

use Illuminate\Support\Facades\Auth;

Trait AuthUserPermissions
{
    /**
     * Get the authenticated user permissions.
     */
    public function getAuthUserPermissions(): array
    {
        return Auth::user()->getPermissions();
    }
}
