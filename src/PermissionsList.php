<?php

namespace NjDigitalLab\LaraPermissions;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PermissionsList
{
    /**
     * Get all the permissions.
     * 
     * @param  $path  string  The relative path inside App/Permissions where the permission files reside.
     */
    public static function getPermissions(string $path = null): array
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
     * @param  $path  string  The relative path in App/Permissions where the permission files reside.
     */
    public static function getPermissionsList(string $path = null): array
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
     * @param  $path  string  The relative path in App/Permissions where the permission files reside.
     */
    public static function getDomainPermissionsValues(string $id, string $path = null): array
    {
        if (empty($path)) {
            $path = '\App\Permissions';
        } else {
            $path = '\App\Permissions\\'.str_replace("/", "\\", $path);
        }

        $class = $path.'\\'.Str::studly($id).'Permissions';

        return $class::getPermissionsValues();
    }

    /**
     * Get the domain ids.
     * 
     * @param  $path  string  The relative path in App/Permissions where the permission files reside.
     */
    public static function getDomainIds(string $path = null): array
    {
        $results = [];

        if (empty($path)) {
            $path = 'Permissions';
        } else {
            $path = 'Permissions/'.rtrim($path, '/');
        }

        $files = File::allFiles(app_path($path));

        foreach ($files as $file) {
            $classname = rtrim($file->getFilename(), '.'.$file->getExtension());
            $class = '\App\\'.str_replace("/", "\\", $path).'\\'.$classname;

            $results[] = $class::getDomainId();
        }

        return $results;
    }
}
