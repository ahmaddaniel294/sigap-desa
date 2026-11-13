<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('warga', 'admin', 'teknisi') NOT NULL DEFAULT 'warga'");
        }

        Schema::table('complaints', function (Blueprint $table) {
            $table->foreignId('technician_id')->nullable()->after('user_id')->constrained('users')->nullOnDelete();
            $table->text('technician_note')->nullable()->after('admin_note');
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropConstrainedForeignId('technician_id');
            $table->dropColumn('technician_note');
        });

        if (DB::getDriverName() === 'mysql') {
            DB::table('users')->where('role', 'teknisi')->update(['role' => 'warga']);
            DB::statement("ALTER TABLE users MODIFY role ENUM('warga', 'admin') NOT NULL DEFAULT 'warga'");
        }
    }
};
