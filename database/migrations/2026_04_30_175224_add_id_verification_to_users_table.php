<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('id_photo_path')->nullable()->after('is_verified_seller');
            $table->enum('id_verification_status', ['pending', 'approved', 'rejected'])->default('pending')->after('id_photo_path');
            $table->text('id_verification_notes')->nullable()->after('id_verification_status');
            $table->timestamp('id_verified_at')->nullable()->after('id_verification_notes');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['id_photo_path', 'id_verification_status', 'id_verification_notes', 'id_verified_at']);
        });
    }
};
