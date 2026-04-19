<?php

namespace NjDigitalLab\LaraPermissions;

class LaraPermissions
{
    /**
     * Get the stubs directory path.
     */
    public static function stubsPath(): string
    {
        return __DIR__.'/../stubs';
    }

    /**
     * Get the temp directory path.
     */
    public static function tempPath(): string
    {
        return __DIR__.'/../temp';
    }
}