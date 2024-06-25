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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id('id');
            $table->text('desc');
            $table->date('date');
            $table->time('time');
            $table->unsignedBigInteger('assigned_to');
            $table->string('category');
            $table->string('link');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');

            $table->foreign('assigned_to')
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
        Schema::drop('tasks');
    }
};
