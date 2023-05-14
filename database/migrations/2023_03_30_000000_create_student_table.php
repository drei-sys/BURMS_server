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
        Schema::create('student', function (Blueprint $table) {
            $table->integer('id')->primary();                        
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('extname')->nullable();
            $table->string('birth_date');
            $table->string('birth_place');
            $table->string('gender');
            $table->string('house_number');
            $table->string('street');
            $table->string('subdivision');
            $table->string('barangay');
            $table->string('city');
            $table->string('province');
            $table->string('zipcode');
            $table->string('civil_status');
            $table->string('contact');
            $table->string('is_cabuyeno');
            $table->string('is_registered_voter');
            $table->string('is_fully_vaccinated');
            $table->string('father_name');
            $table->string('father_occupation');
            $table->string('father_contact');
            $table->string('is_father_voter_of_cabuyao');
            $table->string('mother_name');
            $table->string('mother_occupation');
            $table->string('mother_contact');
            $table->string('is_mother_voter_of_cabuyao');
            $table->string('is_living_with_parents');
            $table->string('education_attained');
            $table->string('last_school_attended');
            $table->string('school_address');
            $table->string('award_received');
            $table->string('sh_school_strand');
            $table->string('email');
            $table->integer('course_id');
            $table->string('year_level');
            $table->string('user_type');            
            $table->text('block_hash')->nullable();
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
        Schema::dropIfExists('student');
    }
};
