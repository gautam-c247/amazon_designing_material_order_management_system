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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->foreignId('user_id')->constrained()->comment('The merchant who created the project');
            $table->foreignId('product_id')->constrained();
            $table->foreignId('service_id')->constrained();
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->text('guidelines')->nullable();
            $table->text('notes')->nullable();
            $table->date('estimated_delivery_date')->nullable();
            $table->enum('status', ['Pending', 'In progress', 'Completed','Ready for review'])->default('In progress');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
