<?php

namespace NjDigitalLab\LaraPermissions;

use Illuminate\Database\Eloquent\Model;
use NjDigitalLab\LaraPermissions\Contracts\HasAbility;
use NjDigitalLab\LaraPermissions\Contracts\HasAuthUserPermissions;
use NjDigitalLab\LaraPermissions\Traits\AuthUserPermissions;
use NjDigitalLab\LaraPermissions\Traits\ValidateAbility;

abstract class Policy implements HasAbility, HasAuthUserPermissions
{
    use AuthUserPermissions, ValidateAbility;

    /**
     * Determine whether the user can perform all action.
     */
    public function before(Model $user, string $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the menu.
     */
    public function menu(Model $user): bool
    {
        return $this->hasAbility('menu');
    }

    /**
     * Determine whether the user can view the list of models.
     */
    public function viewList(Model $user): bool
    {
        return $this->hasAbility('view_list');
    }

    /**
     * Determine whether the user can view the list of trashed models.
     */
    public function viewTrashList(Model $user): bool
    {
        return $this->hasAbility('view_trash_list');
    }

    /**
     * Determine whether the user can create a model.
     */
    public function create(Model $user): bool
    {
        return $this->hasAbility('create');
    }

    /**
     * Determine whether the user can view a specific table.
     */
    public function view(Model $user, Model $model): bool
    {
        return $this->hasAbility('view');
    }

    /**
     * Determine whether the user can update a specific model.
     */
    public function update(Model $user, Model $model): bool
    {
        return $this->hasAbility('update');
    }

    /**
     * Determine whether the user can trash a specific model.
     */
    public function trash(Model $user, Model $model): bool
    {
        return $this->hasAbility('trash');
    }

    /**
     * Determine whether the user can restore a specific model.
     */
    public function restore(Model $user, Model $model): bool
    {
        return $this->hasAbility('restore');
    }

    /**
     * Determine whether the user can destroy a specific model.
     */
    public function destroy(Model $user, Model $model): bool
    {
        return $this->hasAbility('destroy');
    }

    /**
     * Determine whether the user has the create ability.
     */
    public function performCreate(Model $user): bool
    {
        return $this->hasAbility('create');
    }

    /**
     * Determine whether the user has the view ability.
     */
    public function performView(Model $user): bool
    {
        return $this->hasAbility('view');
    }

    /**
     * Determine whether the user has the update ability.
     */
    public function performUpdate(Model $user): bool
    {
        return $this->hasAbility('update');
    }

    /**
     * Determine whether the user has the trash ability.
     */
    public function performTrash(Model $user): bool
    {
        return $this->hasAbility('trash');
    }

    /**
     * Determine whether the user has the restore ability.
     */
    public function performRestore(Model $user): bool
    {
        return $this->hasAbility('restore');
    }

    /**
     * Determine whether the user has the destroy ability.
     */
    public function performDestroy(Model $user): bool
    {
        return $this->hasAbility('destroy');
    }

    /**
     * Determine whether the user has search ability.
     */
    public function performSearch(Model $user): bool
    {
        return $this->hasAbility('search');
    }

    /**
     * Determine whether the user has bulk request ability.
     */
    public function performBulkRequest(Model $user): bool
    {
        return $this->hasAbility('bulk_request');
    }
}
