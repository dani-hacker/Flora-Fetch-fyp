<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('category', 80);        // Indoor, Outdoor, Succulents, Herbs
            $table->decimal('price', 8, 2);
            $table->string('sunlight_requirement', 80); // Full Sun, Partial Shade, Low Light
            $table->string('watering_need', 80);        // Low, Moderate, High  [Fixed v4.0]
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->string('image_url', 255)->nullable();    // [Added v4.0]
            $table->text('description')->nullable();         // [Added v4.0]
            $table->timestamps();

            // Index for fast filtering
            $table->index('category');
            $table->index('sunlight_requirement');
            $table->index('watering_need');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plants');
    }
};
