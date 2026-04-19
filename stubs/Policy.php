<?php

namespace {namespace};

use {usestatement};
use NjDigitalLab\LaraPermissions\Policy;

class {classname} extends Policy
{
    /**
     * Get the permissions class name.
     */
    public function getPermissionsClassName(): string
    {
        return {permissionclassname}::class;
    }
}
