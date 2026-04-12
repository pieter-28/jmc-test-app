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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 20)->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('place_of_birth', 100);
            $table->unsignedBigInteger('sub_district_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->text('address');
            $table->date('date_of_birth');
            $table->enum('marital_status', ['kawin', 'tidak kawin']);
            $table->unsignedTinyInteger('number_of_children')->default(0);
            $table->date('start_date');
            $table->enum('employment_type', ['tetap', 'kontrak', 'magang'])->default('kontrak');
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedTinyInteger('age')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('sub_district_id')->references('id')->on('sub_districts')->onDelete('set null');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('set null');
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('set null');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('restrict');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
