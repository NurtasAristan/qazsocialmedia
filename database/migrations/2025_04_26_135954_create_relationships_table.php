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
            $table->foreignId('person1_id')->constrained('people')->onDelete('cascade');
            $table->foreignId('person2_id')->constrained('people')->onDelete('cascade');
            $table->enum('type', ['parent', 'spouse']); // 'parent' means person1 is parent of person2
            $table->timestamps();
        
            $table->unique(['person1_id', 'person2_id', 'type']);
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
