<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUssdSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ussd_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('session_id');
            $table->string('phone_number');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('current_view_id')->nullable();
            $table->text('state')->nullable();
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
        Schema::dropIfExists('ussd_sessions');
    }
}
