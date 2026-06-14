<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('organization_name')->default('نظام الشكاوى');
            $table->string('organization_name_en')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('header_image_path')->nullable();
            $table->string('primary_color')->default('#0d6d8e');
            $table->string('website_url')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('welcome_message')->nullable();
            $table->text('footer_text')->nullable();
            $table->boolean('tracking_enabled')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
