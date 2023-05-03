<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TORRequest extends Model
{
    use HasFactory;

    protected $table = 'tor_request';

    protected $fillable = [
        'student_id',
        'reason',
        'remarks',
        'block_hash',
        'status',
        'created_by',
        'updated_by',
    ];
}
