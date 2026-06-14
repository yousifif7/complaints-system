<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'catName_en')) {
                $table->string('catName_en')->nullable()->after('catName');
            }
        });

        Schema::table('request_types', function (Blueprint $table) {
            if (!Schema::hasColumn('request_types', 'request_name_en')) {
                $table->string('request_name_en')->nullable()->after('request_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'catName_en')) {
                $table->dropColumn('catName_en');
            }
        });

        Schema::table('request_types', function (Blueprint $table) {
            if (Schema::hasColumn('request_types', 'request_name_en')) {
                $table->dropColumn('request_name_en');
            }
        });
    }
};
