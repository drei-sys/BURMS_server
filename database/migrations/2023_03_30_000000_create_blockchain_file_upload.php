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
        Schema::create('blockchain_file_upload', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->string('filename');
            $table->string('description')->nullable();
            $table->string('category');
            $table->string('pid');
            $table->string('block_hash');
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
        Schema::dropIfExists('blockchain_file_upload');
    }
};
