<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'student';

    protected $fillable = [
        'id',        
        'lastname',
        'firstname',
        'middlename',
        'extname',
        'birth_date',
        'birth_place',
        'gender',
        'address',
        'civil_status',
        'contact',
        'is_cabuyeno',
        'is_registered_voter',
        'is_fully_vaccinated',
        'father_name',
        'father_occupation',
        'father_contact',
        'is_father_voter_of_cabuyao',
        'mother_name',
        'mother_occupation',
        'mother_contact',
        'is_mother_voter_of_cabuyao',
        'is_living_with_parents',
        'education_attained',
        'last_school_attended',
        'school_address',
        'award_received',
        'sh_school_strand',
        'email',
        'course_id',
        'year_level',
        'user_type',
        'status',
        'hash',
        'block_hash',
        'created_by',
        'updated_by',
    ];
}
