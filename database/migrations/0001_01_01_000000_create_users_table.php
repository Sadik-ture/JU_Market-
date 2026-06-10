<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('student_id')->unique();           // Added
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('university_domain');              // Added
            $table->string('department')->nullable();         // Added
            $table->integer('graduation_year')->nullable();   // Added
            $table->string('profile_photo')->nullable();      // Added
            $table->text('bio')->nullable();                  // Added
            $table->boolean('is_verified_seller')->default(false);  // Added
            $table->decimal('rating_avg', 2, 1)->default(0);  // Added
            $table->timestamp('last_seen_at')->nullable();    // Added
            $table->boolean('is_suspended')->default(false);  // Added
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
