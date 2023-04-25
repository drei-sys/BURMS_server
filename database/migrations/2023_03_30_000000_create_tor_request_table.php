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
        Schema::create('tor_request', function (Blueprint $table) {
            $table->id();            
            $table->integer('student_id');
            $table->string('reason');
            $table->string('remarks');            
            $table->string('status');            
            $table->integer('created_by');
            $table->integer('updated_by');            
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
        Schema::dropIfExists('tor_request');
    }
};
