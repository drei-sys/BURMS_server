<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeptChair extends Model
{
    use HasFactory;

    protected $table = 'dept_chair';

    protected $fillable = [
        'id',
        'name',
        'user_type',
        'status',
        'hash',
        'created_by',
        'updated_by',
    ];
}
