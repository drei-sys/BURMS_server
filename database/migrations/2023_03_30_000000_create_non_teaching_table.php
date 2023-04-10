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
        Schema::create('non_teaching', function (Blueprint $table) {
            $table->integer('id')->primary();            
            $table->string('name');
            $table->tinyInteger('user_type');
            $table->string('status');            
            $table->string('hash');
            $table->string('block_hash')->nullable();
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
        Schema::dropIfExists('non_teaching');
    }
};
