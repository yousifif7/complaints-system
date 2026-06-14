<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'welcome_message_en')) {
                $table->text('welcome_message_en')->nullable()->after('welcome_message');
            }
            if (!Schema::hasColumn('settings', 'footer_text_en')) {
                $table->string('footer_text_en')->nullable()->after('footer_text');
            }
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'welcome_message_en')) {
                $table->dropColumn('welcome_message_en');
            }
            if (Schema::hasColumn('settings', 'footer_text_en')) {
                $table->dropColumn('footer_text_en');
            }
        });
    }
};
