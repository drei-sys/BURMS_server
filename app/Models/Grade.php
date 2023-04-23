<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'grade';

    protected $fillable = [
        'sy_id',         
        'course_id',         
        'section_id',         
        'subject_id',         
        'student_id',         
        'teacher_id',         
        'prelim_items',         
        'midterm_items',         
        'final_items',
        'prelim_grade',
        'midterm_grade',
        'final_grade',
        'grade',
        'equivalent',
        'remarks',
        'status',
        'hash',
        'created_by',
        'updated_by',     
    ];
}
