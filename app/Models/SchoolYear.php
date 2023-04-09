<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    use HasFactory;

    protected $table = 'sy';

    protected $fillable = [
        'year',
        'semester',
        'status',
        'created_by',
        'updated_by',
    ];
}
