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
        Schema::create('milestones', function (Blueprint $table) {
            $table->id();
            $table->string('name');  
            $table->date('target_completion_date');
            $table->string('deliverable');  
            $table->enum('status', ['Pending', 'In Progress', 'Completed','Delayed'])->default('Pending');
            $table->text('remarks')->nullable();
            $table->date('updated_date');
            $table->foreignId('grant_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milestones');
    }
};
