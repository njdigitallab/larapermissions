<?php

namespace NjDigitalLab\LaraPermissions;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PermissionsList
{
    /**
     * Get all the permissions.
     * 
     * @param  $path  string  he path where the permission files reside.
     */
    public static function getPermissions(string $path): array
    {
        $results = [];

        foreach (static::getPermissionsList($path) as $key => $values) {
            foreach ($values as $value) {
                $results[] = $value;
            }
        }

        return $results;
    }

    /**
     * Get the permission options.
     * 
     * @param  $path  string  he path where the permission files reside.
     */
    public static function getPermissionsList(string $path): array
    {
        $results = [];

        foreach (static::getDomainIds($path) as $id) {
            $results[$id] = static::getDomainPermissionsValues($id, $path);
        }

        return $results;
    }

    /**
     * Get the domain permissions values.
     * 
     * @param  $id  string  The permission identifier
     * @param  $path  string  he path where the permission files reside.
     */
    public static function getDomainPermissionsValues(string $id, string $path): array
    {
        $path = '\App\\'.str_replace("/", "\\", $path);

        $class = $path.'\\'.Str::studly($id).'Permissions';

        return $class::getPermissionsValues();
    }

    /**
     * Get the domain ids.
     * 
     * @param  $path  string  he path where the permission files reside.
     */
    public static function getDomainIds(string $path): array
    {
        $results = [];

        $files = File::allFiles(app_path($path));

        foreach ($files as $file) {
            $classname = rtrim($file->getFilename(), '.'.$file->getExtension());
            $class = '\App\\'.str_replace("/", "\\", $path).'\\'.$classname;

            $results[] = $class::getDomainId();
        }

        return $results;
    }
}
