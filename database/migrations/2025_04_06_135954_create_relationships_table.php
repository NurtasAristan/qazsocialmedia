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
        Schema::create('relationships', function (Blueprint $table) {
            $table->id();

            // From: either user or person (only one must be filled)
            $table->foreignId('from_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('from_person_id')->nullable()->constrained('persons')->onDelete('cascade');

            // To: either user or person (only one must be filled)
            $table->foreignId('to_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('to_person_id')->nullable()->constrained('persons')->onDelete('cascade');
            
            // Relationship type (e.g., parent, sibling, friend)
            $table->string('type');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relationships');
    }
};
