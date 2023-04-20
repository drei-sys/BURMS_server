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
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('extname')->nullable();
            $table->string('birth_date');
            $table->string('birth_place');
            $table->string('gender');
            $table->string('civil_status');
            $table->string('citizenship');
            $table->string('house_number');
            $table->string('street');
            $table->string('subdivision');
            $table->string('barangay');
            $table->string('city');
            $table->string('province');
            $table->string('zipcode');
            $table->string('gsis');
            $table->string('pagibig');
            $table->string('philhealth');
            $table->string('sss');
            $table->string('tin');
            $table->string('agency_employee_no')->nullable();
            $table->string('elementary_school')->nullable();
            $table->string('elementary_remarks')->nullable();
            $table->string('secondary_school')->nullable();
            $table->string('secondary_remarks')->nullable();
            $table->string('vocational_school')->nullable();
            $table->string('vocational_remarks')->nullable();
            $table->string('college_school')->nullable();
            $table->string('college_remarks')->nullable();
            $table->string('graduate_studies_school')->nullable();
            $table->string('graduate_studies_remarks')->nullable();
            $table->text('work_experiences')->nullable();
            $table->string('email');
            $table->string('user_type');
            $table->string('hash');
            $table->string('block_hash')->nullable();
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
        Schema::dropIfExists('non_teaching');
    }
};
