<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentItem extends Model
{
    use HasFactory;

    protected $table = 'enrollment_item';

    protected $fillable = [
        'enrollment_id',
        'sy_id',
        'course_id',
        'section_id',
        'subject_id',
        'created_by',
        'updated_by',
    ];
}
