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
        Schema::create('pastes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('slug', 15)->unique(); // e.g., 'aB8x9Z'
            $table->string('title')->nullable();
            $table->longText('content');
            $table->string('syntax')->default('plaintext'); // php, javascript, html, etc.
            $table->enum('visibility', ['public', 'unlisted', 'private'])->default('public');
            $table->string('password')->nullable(); // Hashed password
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            // Indexing for performance on public feeds
            $table->index(['visibility', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pastes');
    }
};
