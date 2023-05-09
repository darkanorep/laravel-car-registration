<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('plate_numbers', function (Blueprint $table) {
            $table->enum('is_approved', ['approved', 'rejected', 'pending'])->default('pending');
            $table->string('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plate_numbers', function (Blueprint $table) {
            //
        });
    }
};
