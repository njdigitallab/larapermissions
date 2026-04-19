<?php

namespace NjDigitalLab\LaraPermissions\Contracts;

interface HasDomainId
{
    /**
     * Get the domain id.
     */
    public static function getDomainId(): string;
}
