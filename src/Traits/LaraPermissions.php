<?php

namespace NjDigitalLab\LaraPermissions\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

Trait LaraPermissions
{
    /**
     * Check if the user is a super admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->super_admin === 1;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * Interact with the user's permissions.
     */
    protected function permissions(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => json_decode($value),
            set: fn (array $value) => json_encode($value),
        );
    }
}
