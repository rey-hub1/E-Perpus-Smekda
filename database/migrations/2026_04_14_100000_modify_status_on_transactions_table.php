<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement(
            "ALTER TABLE transactions MODIFY COLUMN status ENUM('menunggu_pengambilan', 'dipinjam', 'mengembalikan', 'kembali', 'dibatalkan') NOT NULL DEFAULT 'menunggu_pengambilan'"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(
            "ALTER TABLE transactions MODIFY COLUMN status ENUM('dipinjam', 'mengembalikan', 'kembali') NOT NULL DEFAULT 'dipinjam'"
        );
    }
};
