<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Change from ENUM to VARCHAR
            $table->string('id_verification_status')->default('pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('id_verification_status', ['pending', 'approved', 'rejected'])->default('pending')->change();
        });
    }
};
