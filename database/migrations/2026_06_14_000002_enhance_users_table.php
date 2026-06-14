<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable()->after('id');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('admin')->after('password');
            }
            if (!Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken();
            }
        });

        try {
            Schema::table('users', function (Blueprint $table) {
                $table->unique('email');
            });
        } catch (\Throwable $e) {
            // Unique index may already exist
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            try {
                $table->dropUnique(['email']);
            } catch (\Throwable $e) {
            }

            $columns = array_filter([
                Schema::hasColumn('users', 'name') ? 'name' : null,
                Schema::hasColumn('users', 'role') ? 'role' : null,
                Schema::hasColumn('users', 'remember_token') ? 'remember_token' : null,
            ]);

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
