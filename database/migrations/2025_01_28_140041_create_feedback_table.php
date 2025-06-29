<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('feature');
            $table->text('usability')->nullable();
            $table->text('performance')->nullable();
            $table->text('experience')->nullable();
            $table->text('suggestions')->nullable();
            $table->string('priority')->default('LOW');
            $table->string('status')->default('UNDER_REVIEW');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};