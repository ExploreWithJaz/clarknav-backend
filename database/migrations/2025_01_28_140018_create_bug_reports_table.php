<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bug_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('category')->default('Other');
            $table->text('description');
            $table->text('steps');
            $table->text('expected');
            $table->text('actual');
            $table->text('device');
            $table->string('frequency')->default('Rarely');
            $table->json('screenshots')->nullable();
            $table->string('priority')->default('LOW');
            $table->string('status')->default('OPEN');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bug_reports');
    }
};