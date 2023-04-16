<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSubjectItem extends Model
{
    use HasFactory;

    protected $table = 'teacher_subject_item';

    protected $fillable = [
        'sy_id',
        'teacher_subject_id',
        'subject_id',        
        'created_by',
        'updated_by',
    ];
}
