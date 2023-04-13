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
        Schema::create('grade', function (Blueprint $table) {
            $table->id();            
            $table->integer('sy_id');         
            $table->integer('course_id');         
            $table->integer('section_id');         
            $table->integer('subject_id');         
            $table->integer('student_id');         
            $table->integer('teacher_id');         
            $table->text('prelims_items');         
            $table->text('midterm_items');         
            $table->text('finals_items');
            $table->decimal('prelim_grade', 8, 2);
            $table->decimal('midterm_grade', 8, 2);
            $table->decimal('finals_grade', 8, 2);
            $table->decimal('final_grade', 8, 2);
            $table->decimal('equivalent', 8, 2);
            $table->string('remarks', 8, 2);
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
        Schema::dropIfExists('grade');
    }
};
