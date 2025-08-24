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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
             $table->string('date')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('due_amount')->nullable();
            $table->string('business_name')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('status')->nullable();
         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
