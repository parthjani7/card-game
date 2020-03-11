<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->string('generated_cards');
            $table->string('user_cards');
            $table->unsignedTinyInteger('generated_points')->default(0);
            $table->unsignedTinyInteger('user_points')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_user_won');
            $table->boolean('is_machine_won'); //added this field to determine if game was tie
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('scores');
    }
}
