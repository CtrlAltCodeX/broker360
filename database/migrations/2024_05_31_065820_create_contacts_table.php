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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('position')->nullable();
            $table->string('company')->nullable();
            $table->string('fountain')->nullable();
            $table->string('number');
            $table->string('email');
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('skype')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contacts');
    }
};
