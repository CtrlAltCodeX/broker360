<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id('id');
            $table->string('type');
            $table->string('ad_type');
            $table->text('ad_desc');
            $table->string('operation_type');
            $table->integer('show_price_ad');
            $table->string('bedroom')->nullable();
            $table->string('bathrooms')->nullable();
            $table->string('half_bath')->nullable();
            $table->string('parking_lots')->nullable();
            $table->string('construction')->nullable();
            $table->string('year_construction')->nullable();
            $table->integer('number_plants')->nullable();
            $table->integer('number_floors')->nullable();
            $table->integer('monthly_maintence')->nullable();
            $table->string('internal_key')->nullable();
            $table->string('key_code')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade'); // Optional: Define the action on delete
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('properties');
    }
};
