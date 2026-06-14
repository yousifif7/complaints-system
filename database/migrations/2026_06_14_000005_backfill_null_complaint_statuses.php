<?php

use App\Enums\ComplaintStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('form_types')
            ->whereNull('status')
            ->orWhere('status', '')
            ->update(['status' => ComplaintStatus::ACTIVE]);
    }

    public function down(): void
    {
        //
    }
};
