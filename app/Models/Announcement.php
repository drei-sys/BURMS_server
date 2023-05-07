<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $table = 'announcement';

    protected $fillable = [
        'name',
        'description',
        'status',
        'created_by',
        'updated_by',
    ];
}
