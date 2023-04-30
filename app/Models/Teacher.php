<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teacher';

    protected $fillable = [
        'id',
        'lastname',
        'firstname',
        'middlename',
        'extname',
        'birth_date',
        'birth_place',
        'gender',
        'civil_status',
        'citizenship',
        'house_number',
        'street',
        'subdivision',
        'barangay',
        'city',
        'province',
        'zipcode',
        'gsis',
        'pagibig',
        'philhealth',
        'sss',
        'tin',
        'agency_employee_no',
        'elementary_school',
        'elementary_remarks',
        'secondary_school',
        'secondary_remarks',
        'vocational_school',
        'vocational_remarks',
        'college_school',
        'college_remarks',
        'graduate_studies_school',
        'graduate_studies_remarks',
        'work_experiences',
        'email',
        'user_type',
        'status',
        'hash',
        'block_hash',
        'created_by',
        'updated_by',
    ];
}
