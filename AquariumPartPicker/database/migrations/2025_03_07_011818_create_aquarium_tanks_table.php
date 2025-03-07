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
        Schema::create('aquarium_tanks', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('brand');
        $table->float('volume_gallons');
        $table->float('length_inches');
        $table->float('width_inches');
        $table->float('height_inches');
        $table->string('glass_type')->nullable();
        $table->text('description')->nullable();
        $table->decimal('price', 8, 2);
        $table->string('image_url')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aquarium_tanks');
    }
};
