<?php

namespace NjDigitalLab\LaraPermissions;

class LaraPermissions
{
    /**
     * If to use name instead of first and last name.
     */
    private static bool $useNameOnly = false;

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

    /**
     * If to use name only.
     */
    public static function useNameOnly(): void
    {
        static::$useNameOnly = true;
    }

    /**
     * Check if we are using the name only.
     */
    public static function isUsingNameOnly(): bool
    {
        return static::$useNameOnly;
    }
}