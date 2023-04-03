<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrar extends Model
{
    use HasFactory;

    protected $table = 'registrar';

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
