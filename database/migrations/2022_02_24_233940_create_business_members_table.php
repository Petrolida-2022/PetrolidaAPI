<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('business_competition_id');
            $table->string('register_code');
            $table->string('name');
            $table->string('email')->unique();
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
        Schema::dropIfExists('business_members');
    }
}
