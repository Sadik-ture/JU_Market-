<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('to_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('listing_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_id')->constrained()->onDelete('cascade');
            $table->integer('rating')->unsigned()->between(1, 5);
            $table->text('review')->nullable();
            $table->json('images')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();

            $table->index(['to_user_id', 'rating']);
            $table->unique(['from_user_id', 'listing_id', 'payment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
