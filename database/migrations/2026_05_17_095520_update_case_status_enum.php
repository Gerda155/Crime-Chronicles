<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE cases
            MODIFY status ENUM(
                'draft',
                'pending',
                'active',
                'inactive'
            ) NOT NULL DEFAULT 'draft'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE cases
            MODIFY status ENUM(
                'pending',
                'active',
                'inactive'
            ) NOT NULL DEFAULT 'pending'
        ");
    }
};