<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockchainFileUpload extends Model
{
    use HasFactory;

    protected $table = 'blockchain_file_upload';

    protected $fillable = [
        'student_id',
        'filename',
        'description',
        'category',
        'pid',
        'block_hash',
        'created_by',
        'updated_by',
    ];
}
