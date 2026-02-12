<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE users ALTER COLUMN role TYPE TEXT USING role::text");
            DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'peminjam'");
            DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin','petugas','peminjam'))");
        } else {
            // Fallback for MySQL/MariaDB (requires doctrine/dbal for change)
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'petugas', 'peminjam'])->default('peminjam')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            if (Schema::hasColumn('users', 'role')) {
                DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
                DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin','peminjam'))");
                DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'peminjam'");
            }
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'peminjam'])->default('peminjam')->change();
            });
        }
    }
};
