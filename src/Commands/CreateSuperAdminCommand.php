<?php

namespace NjDigitalLab\LaraPermissions\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;
use function Laravel\Prompts\password;

class CreateSuperAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larapermissions:create-super-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a super admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $firstName = text(
            label: 'What is the first name?',
            required: true
        );

        $lastName = text(
            label: 'What is the last name?',
            required: true
        );

        $email = text(
            label: 'what is the email address?',
            required: true
        );

        $password = password(
            label: 'What is the password?',
            required: true
        );

        $userClass = config('auth.providers.users.model');

        new $userClass()->forceFill([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $password,
            'email_verified_at' => now(),
            'super_admin' => 1,
            'permissions' => [],
        ])->save();

        $this->info('Super admin created successfully!');
    }
}


