<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_pricings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('case_id');
            $table->string('part_name');
            $table->integer('qty');
            $table->string('part_no')->nullable();
            $table->decimal('price')->nullable();
            $table->decimal('discount')->nullable();
            $table->decimal('total')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_pricings');
    }
};
