<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $table = 'enrollment';

    protected $fillable = [
        'student_id',
        'sy_id',
        'status',
        'created_by',
        'updated_by',
    ];
}
