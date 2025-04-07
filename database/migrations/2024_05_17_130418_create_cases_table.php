<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_no');
            $table->string('brand');
            $table->string('model');
            $table->string('year');
            $table->string('vin');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('assigned_to')->nullable();
            $table->date('date');
            $table->date('closing_date')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'close'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
