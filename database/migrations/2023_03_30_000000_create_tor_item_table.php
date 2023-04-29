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
        Schema::create('tor_item', function (Blueprint $table) {
            $table->id();
            $table->integer('tor_request_id');
            $table->integer('sy_id');
            $table->string('subject_code');
            $table->string('subject_name');
            $table->decimal('rating', 8, 2);
            $table->integer('credits');
            $table->string('completion_grade');
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
        Schema::dropIfExists('tor_item');
    }
};
