<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('name');
            $table->unsignedInteger('grind_size');
            $table->double('brewing_temperature');
            $table->double('ground_coffee_amount');
            $table->double('bloom_amount');
            $table->double('coffee_water_ratio');
            $table->unsignedInteger('bloom_time');
            $table->unsignedInteger('total_brew_time');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brews');
    }
}
