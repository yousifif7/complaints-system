<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_types', function (Blueprint $table) {
            if (!Schema::hasColumn('form_types', 'status')) {
                $table->string('status')->default('1')->after('file');
            }
            if (!Schema::hasColumn('form_types', 'ticket_number')) {
                $table->string('ticket_number')->nullable()->after('file');
            }
            if (!Schema::hasColumn('form_types', 'priority')) {
                $table->string('priority')->default('medium');
            }
            if (!Schema::hasColumn('form_types', 'internal_notes')) {
                $table->text('internal_notes')->nullable();
            }
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE form_types MODIFY content TEXT');
        }

        $complaints = DB::table('form_types')->whereNull('ticket_number')->orderBy('id')->get();
        foreach ($complaints as $complaint) {
            $prefix = sprintf('CMP-%s%s-', $complaint->category_id, $complaint->requesttype_id);
            $sequence = str_pad((string) $complaint->id, 5, '0', STR_PAD_LEFT);
            DB::table('form_types')
                ->where('id', $complaint->id)
                ->update(['ticket_number' => $prefix . $sequence]);
        }

        if (Schema::hasColumn('form_types', 'ticket_number')) {
            $indexes = collect(DB::select("SHOW INDEX FROM form_types WHERE Key_name = 'form_types_ticket_number_unique'"));
            if ($indexes->isEmpty()) {
                Schema::table('form_types', function (Blueprint $table) {
                    $table->unique('ticket_number');
                });
            }
        }
    }

    public function down(): void
    {
        Schema::table('form_types', function (Blueprint $table) {
            if (Schema::hasColumn('form_types', 'ticket_number')) {
                $table->dropUnique(['ticket_number']);
            }
            $columns = array_filter([
                Schema::hasColumn('form_types', 'status') ? 'status' : null,
                Schema::hasColumn('form_types', 'ticket_number') ? 'ticket_number' : null,
                Schema::hasColumn('form_types', 'priority') ? 'priority' : null,
                Schema::hasColumn('form_types', 'internal_notes') ? 'internal_notes' : null,
            ]);
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE form_types MODIFY content VARCHAR(255)');
        }
    }
};
