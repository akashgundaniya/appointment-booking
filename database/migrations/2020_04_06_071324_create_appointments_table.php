<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id'); 
            $table->string('title'); 
            $table->datetime('start_time')->nullable();
            $table->datetime('end_time')->nullable(); 
            $table->string('attachment')->nullable(); 
            $table->text('notes')->nullable(); 
            $table->timestamps(); 

            $table->foreign('user_id')
             ->references('id')->on('users')
             ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
