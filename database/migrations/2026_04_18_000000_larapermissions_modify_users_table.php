<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $userClass = config('auth.providers.users.model');

        Schema::table(new $userClass()->getTable(), function (Blueprint $table) {
            $table->boolean('super_admin')->default(0);
            $table->text('permissions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $userClass = config('auth.providers.users.model');

        Schema::table(new $userClass()->getTable(), function (Blueprint $table) {
            $table->dropColumn('super_admin');
            $table->dropColumn('permissions');
        });
    }
};
