<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('user_libraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['reading', 'saved', 'finished']);
            $table->timestamps();

            $table->unique(['user_id', 'book_id']);
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('user_libraries');
    }
};
