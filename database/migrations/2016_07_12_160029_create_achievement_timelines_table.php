<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchievementTimelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievement_timelines', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('achievement_id')->unsigned();
            $table->integer('proof_id')->unsigned();
            $table->integer('claim_id')->unsigned();
            $table->integer('goal_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('achievement_timelines');
    }
}
