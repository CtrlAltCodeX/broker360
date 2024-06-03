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
        Schema::table('properties', function (Blueprint $table) {
            $table->string('street')->nullable();
            $table->string('corner_with')->nullable();
            $table->integer('postal_code')->nullable();
            $table->string('property_features')->nullable();
            $table->tinyInteger('share_commission')->nullable();
            $table->integer('commission_percent')->nullable();
            $table->string('condition_sharing')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            //
        });
    }
};
