<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // First drop the ENUM column
            $table->dropColumn('id_verification_status');
        });

        Schema::table('users', function (Blueprint $table) {
            // Re-add as VARCHAR with default 'pending'
            $table->string('id_verification_status')->default('pending')->after('id_photo_path');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id_verification_status');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('id_verification_status', ['pending', 'approved', 'rejected'])->default('pending')->after('id_photo_path');
        });
    }
};
