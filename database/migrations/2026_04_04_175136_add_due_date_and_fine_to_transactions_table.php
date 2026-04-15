<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->date('due_date')->nullable()->after('tanggal_pinjam');
            $table->integer('fine')->default(0)->after('status');
        });
    }

    
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['due_date', 'fine']);
        });
    }
};
