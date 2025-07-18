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
        Schema::create('route_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('route_id');
            $table->string('route_name');
            $table->string('description')->nullable(); // Allow description to be nullable
            $table->string('color');
            $table->string('origin');
            $table->string('destination');
            $table->enum('route_type', ['Jeepney', 'Bus', 'Taxi', 'Walking']); // Use lowercase values
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_usages');
    }
};