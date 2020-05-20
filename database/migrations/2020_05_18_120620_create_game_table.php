<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game', function (Blueprint $table) {
            $table->id();
            $table->string('league_token', 43);
            $table->integer('week_no')->unsigned();
            $table->integer('home_team')->unsigned();
            $table->integer('away_team')->unsigned();
            $table->integer('home_score')->unsigned()->nullable();
            $table->integer('away_score')->unsigned()->nullable();
            $table->boolean('is_played')->default(false);
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
        Schema::dropIfExists('game');
    }
}
