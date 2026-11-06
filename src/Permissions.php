<?php

namespace NjDigitalLab\LaraPermissions;

use NjDigitalLab\LaraPermissions\Contracts\HasDomainId;
use App\Permissions\Admin\Traits\UsesDomainId;

abstract class Permissions implements HasDomainId
{
    /**
     * The cache storage.
     */
    protected static array $cache = [];

    /**
     * Get the role permissions values.
     */
    public static function getPermissionsValues(): array
    {
        if (array_key_exists(static::getDomainId().'_values', static::$cache)) {
            return static::$cache[static::getDomainId().'_values'];
        }

        $results = [];

        foreach (static::getPermissionsList() as $key => $values) {
            foreach ($values as $value) {
                $results[] = $value;
            }
        }

        $results = array_unique($results);

        static::$cache[static::getDomainId().'_values'] = $results;

        return $results;
    }

    /**
     * Get the permissions list.
     */
    public static function getPermissionsList(): array
    {
        if (array_key_exists(static::getDomainId().'_list', static::$cache)) {
            return static::$cache[static::getDomainId().'_list'];
        }

        $list = [
            'menu' => static::getMenuPermissions(),
            'view_list' => static::getViewListPermissions(),
            'view_trash_list' => static::getViewTrashListPermissions(),
            'create' => static::getCreatePermissions(),
            'view' => static::getViewPermissions(),
            'update' => static::getUpdatePermissions(),
            'trash' => static::getTrashPermissions(),
            'restore' => static::getRestorePermissions(),
            'destroy' => static::getDestroyPermissions(),
            'search' => static::getSearchPermissions(),
            'bulk_request' => static::getBulkRequestPermissions(),
        ];

        if (method_exists(static::class, 'customPermissions')) {
            $list = array_merge($list, static::customPermissions());
        }

        static::$cache[static::getDomainId().'_list'] = $list;

        return $list;
    }

    /**
     * Get the menu permissions.
     */
    public static function getMenuPermissions(): array
    {
        $id = static::getDomainId();
        
        return [$id.':create', $id.':update', $id.':trash', $id.':restore', $id.':destroy'];
    }

    /**
     * Get the view list permissions.
     */
    public static function getViewListPermissions(): array
    {
        $id = static::getDomainId();
        
        return [$id.':update', $id.':trash'];
    }

    /**
     * Get the view trash list permissions.
     */
    public static function getViewTrashListPermissions(): array
    {
        $id = static::getDomainId();
        
        return [$id.':restore', $id.':destroy'];
    }

    /**
     * Get the create permissions.
     */
    public static function getCreatePermissions(): array
    {
        $id = static::getDomainId();
        
        return [$id.':create'];
    }

    /**
     * Get the view permissions.
     */
    public static function getViewPermissions(): array
    {
        $id = static::getDomainId();

        return [$id.':update'];
    }

    /**
     * Get the update permissions.
     */
    public static function getUpdatePermissions(): array
    {
        $id = static::getDomainId();
        
        return [$id.':update'];
    }

    /**
     * Get the trash permissions.
     */
    public static function getTrashPermissions(): array
    {
        $id = static::getDomainId();
        
        return [$id.':trash'];
    }

    /**
     * Get the restore permissions.
     */
    public static function getRestorePermissions(): array
    {
        $id = static::getDomainId();
        
        return [$id.':restore'];
    }

    /**
     * Get the destroy permissions.
     */
    public static function getDestroyPermissions(): array
    {
        $id = static::getDomainId();
        
        return [$id.':destroy'];
    }

    /**
     * Get the search permissions.
     */
    public static function getSearchPermissions(): array
    {
        return array_merge(
            static::getViewListPermissions(), static::getViewTrashListPermissions()
        );
    }

    /**
     * Get the bulk request permissions.
     */
    public static function getBulkRequestPermissions(): array
    {
        $id = static::getDomainId();

        return [$id.':trash', $id.':restore', $id.':destroy'];
    }
}
