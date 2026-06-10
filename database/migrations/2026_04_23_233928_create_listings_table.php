<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title', 200);
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->enum('category', ['Electronics', 'Textbooks', 'Furniture', 'Clothing', 'Vehicles', 'Miscellaneous']);
            $table->enum('condition', ['New', 'Like New', 'Good', 'Fair']);
            $table->string('campus')->nullable(); // Auto-detected from email domain
            $table->enum('status', ['Active', 'Sold', 'Expired', 'Draft', 'Archived'])->default('Active');
            $table->integer('views_count')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->foreignId('sold_to_user_id')->nullable()->constrained('users');
            $table->softDeletes(); // Adds deleted_at column for soft delete
            $table->timestamps();

            // Indexes for performance
            $table->index('user_id');
            $table->index('status');
            $table->index('expires_at');
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
