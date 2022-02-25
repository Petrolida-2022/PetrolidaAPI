<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetrosmartCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petrosmart_competitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('register_code');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('team_name');
            $table->string('university');
            $table->string('phone')->unique();
            $table->string('file');
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
        Schema::dropIfExists('petrosmart_competitions');
    }
}
