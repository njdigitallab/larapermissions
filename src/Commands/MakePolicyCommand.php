<?php

namespace NjDigitalLab\LaraPermissions\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use NjDigitalLab\LaraPermissions\LaraPermissions;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class MakePolicyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larapermissions:policy {name : The policy name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a policy';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ensure the policies and permissions directory exists
        new Filesystem()->ensureDirectoryExists(app_path($this->policyDirectory()));
        new Filesystem()->ensureDirectoryExists(app_path($this->permissionDirectory()));

        $this->createPolicyStub();
        $this->createPermissionStub();

        $this->info('Policy created successfully!');
    }

    /**
     * Create the policy stub.
     */
    protected function createPolicyStub(): void
    {
        $search = [
            '{namespace}', '{usestatement}', '{classname}', '{permissionclassname}',
        ];

        $replace = [
            $this->policyNamespace(),
            $this->policyUseStatement(),
            $this->policyClassname(),
            $this->permissionClassname(),
        ];

        $filepath = LaraPermissions::stubsPath().'/Policy.php';
        $content = str_replace($search, $replace, File::get($filepath));

        File::put(app_path($this->policyDirectory()).'/'.$this->policyClassname().'.php', $content);
    }

    /**
     * Create the permission stub.
     */
    protected function createPermissionStub(): void
    {
        $search = [
            '{namespace}', '{classname}', '{domain}',
        ];

        $replace = [
            $this->permissionNamespace(),
            $this->permissionClassname(),
            $this->permissionDomain(),
        ];

        $filepath = LaraPermissions::stubsPath().'/Permissions.php';
        $content = str_replace($search, $replace, File::get($filepath));

        File::put(app_path($this->permissionDirectory()).'/'.$this->permissionClassname().'.php', $content);
    }

    /**
     * Get the name of the policy directory.
     */
    protected function policyDirectory(): string
    {
        return 'Policies/'.rtrim($this->relativePath(), '/');
    }

    /**
     * Get the name of the permissions directory.
     */
    protected function permissionDirectory(): string
    {
        return 'Permissions/'.rtrim($this->relativePath(), '/');
    }

    /**
     * Get the policy name.
     */
    protected function policyClassname()
    {
        preg_match('/(?<=\/){0,1}[A-Z]{1}\w*$/', $this->argument('name'), $matches);

        return $matches[0];
    }

    /**
     * Get the permission class name.
     */
    protected function permissionClassname(): string
    {
        return str_replace('Policy', 'Permissions', $this->policyClassname());
    }

    /**
     * Get the relative path for the file being created.
     */
    protected function relativePath()
    {
        return rtrim($this->argument('name'), $this->policyClassname());
    }

    /**
     * Get the file namespace.
     */
    protected function policyNamespace(): string
    {
        return 'App\Policies\\'.rtrim(str_replace('/', '\\', $this->relativePath()), '\\');
    }

    /**
     * Get the permission namespace.
     */
    protected function permissionNamespace(): string
    {
        return 'App\Permissions\\'.rtrim(str_replace('/', '\\', $this->relativePath()), '\\');
    }

    /**
     * Get the use statement.
     */
    protected function policyUseStatement(): string
    {
        $statement = 'App\Permissions\\'.str_replace('/', '\\', $this->relativePath());

        return $statement.$this->permissionClassname();
    }

    /**
     * Get the permission domain.
     */
    protected function permissionDomain(): string
    {
        $name = $this->permissionClassname();

        return Str::lower(str_replace('Permissions', '', $name));
    }
}
