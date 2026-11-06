<?php

namespace NjDigitalLab\LaraPermissions;

use Illuminate\Database\Eloquent\Model;
use NjDigitalLab\LaraPermissions\Contracts\HasAbility;
use NjDigitalLab\LaraPermissions\Contracts\HasAuthUserPermissions;
use NjDigitalLab\LaraPermissions\Traits\AuthUserPermissions;
use NjDigitalLab\LaraPermissions\Traits\ValidateAbility;

abstract class UserPolicy implements HasAbility, HasAuthUserPermissions
{
    use AuthUserPermissions, ValidateAbility;

    /**
     * Determine whether the user can view the menu.
     */
    public function menu(Model $user): bool
    {
        return $user->isSuperAdmin() ?: $this->hasAbility('menu');
    }

    /**
     * Determine whether the user can view the list of models.
     */
    public function viewList(Model $user): bool
    {
        return $user->isSuperAdmin() ?: $this->hasAbility('view_list');
    }

    /**
     * Determine whether the user can view the list of trashed models.
     */
    public function viewTrashList(Model $user): bool
    {
        return $user->isSuperAdmin() ?: $this->hasAbility('view_trash_list');
    }

    /**
     * Determine whether the user can create a model.
     */
    public function create(Model $user): bool
    {
        return $user->isSuperAdmin() ?: $this->hasAbility('create');
    }

    /**
     * Determine whether the user can view a specific table.
     */
    public function view(Model $user, Model $model): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        // User must be able to view themself
        if ($user->id == $model->id) {
            return true;
        }

        // Only a super admin should be able to view another super admin
        if (! $user->isSuperAdmin() && $model->isSuperAdmin()) {
            return false;
        }

        return $this->hasAbility('view');
    }

    /**
     * Determine whether the user can update a specific model.
     */
    public function update(Model $user, Model $model): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Everyone should be able to update their profile
        if ($user->id == $model->id) {
            return true;
        }

        // Only a super admin should be able to update another super admin
        if (! $user->isSuperAdmin() && $model->isSuperAdmin()) {
            return false;
        }

        return $this->hasAbility('update');
    }

    /**
     * Determine whether the user can trash a specific model.
     */
    public function trash(Model $user, Model $model): bool
    {
        // User cannot trash themselves
        if ($user->id === $model->id) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        // Only a super admin should be able to trash another super admin
        if (! $user->isSuperAdmin() && $model->isSuperAdmin()) {
            return false;
        }

        return $this->hasAbility('trash');
    }

    /**
     * Determine whether the user can restore a specific model.
     */
    public function restore(Model $user, Model $model): bool
    {
        // User cannot restore themself
        if ($user->id == $model->id) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        // Only a super admin should be able to restore another super admin
        if (! $user->isSuperAdmin() && $model->isSuperAdmin()) {
            return false;
        }

        return $this->hasAbility('restore');
    }

    /**
     * Determine whether the user can destroy a specific model.
     */
    public function destroy(Model $user, Model $model): bool
    {
        // User cannot destroy themself
        if ($user->id == $model->id) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        // Only a super admin should be able to destroy another super admin
        if (! $user->isSuperAdmin() && $model->isSuperAdmin()) {
            return false;
        }

        return $this->hasAbility('destroy');
    }

    /**
     * Determine whether the user has the view ability.
     */
    public function performView(Model $user): bool
    {
        return $user->isSuperAdmin() ?: $this->hasAbility('view');
    }

    /**
     * Determine whether the user has the update ability.
     */
    public function performUpdate(Model $user): bool
    {
        return $user->isSuperAdmin() ?: $this->hasAbility('update');
    }

    /**
     * Determine whether the user has the trash ability.
     */
    public function performTrash(Model $user): bool
    {
        return $user->isSuperAdmin() ?: $this->hasAbility('trash');
    }

    /**
     * Determine whether the user has the restore ability.
     */
    public function performRestore(Model $user): bool
    {
        return $user->isSuperAdmin() ?: $this->hasAbility('restore');
    }

    /**
     * Determine whether the user has the destroy ability.
     */
    public function performDestroy(Model $user): bool
    {
        return $user->isSuperAdmin() ?: $this->hasAbility('destroy');
    }

    /**
     * Determine whether the user has search ability.
     */
    public function performSearch(Model $user): bool
    {
        return $user->isSuperAdmin() ?: $this->hasAbility('search');
    }

    /**
     * Determine whether the user has bulk request ability.
     */
    public function performBulkRequest(Model $user): bool
    {
        return $user->isSuperAdmin() ?: $this->hasAbility('bulk_request');
    }
}
