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
        Schema::create('company', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable(); // category_id INT(11) NULL
            $table->string('title', 255); // NOT NULL
            $table->string('image', 255)->nullable();
            $table->text('description')->nullable();
            $table->boolean('status'); // NOT NULL
            $table->timestamps(); // created_at, updated_at -> NOT NULL

            // Foreign key constraint
            $table->foreign('category_id')
                  ->references('id')
                  ->on('category')
                  ->nullOnDelete(); // sets category_id = null if referenced row deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company');
    }
};
