<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedTeacherItem extends Model
{
    use HasFactory;

    protected $table = 'assigned_teacher_item';

    protected $fillable = [
        'sy_id',
        'teacher_id',
        'total_subjects',
        'status',
        'created_by',
        'updated_by',
    ];
}
