<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transport_allowance_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('base_fare', 12, 2); // Base fare per km
            $table->decimal('min_distance', 5, 2)->default(5); // Minimum 5 km
            $table->decimal('max_distance', 5, 2)->default(25); // Maximum 25 km
            $table->unsignedTinyInteger('min_working_days')->default(19); // Minimum 19 days
            $table->timestamp('effective_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_allowance_settings');
    }
};
