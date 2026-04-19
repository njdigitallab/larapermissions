<?php

namespace NjDigitalLab\LaraPermissions\Providers;

use Illuminate\Support\ServiceProvider;
use NjDigitalLab\LaraPermissions\Commands\CreateSuperAdminCommand;
use NjDigitalLab\LaraPermissions\Commands\MakePolicyCommand;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishesMigrations([
            __DIR__.'/../../database/migrations' => database_path('migrations'),
        ], 'larapermissions-migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateSuperAdminCommand::class,
                MakePolicyCommand::class,
            ]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}