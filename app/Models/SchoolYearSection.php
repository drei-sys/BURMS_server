<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SchoolYearSectionItem;

class SchoolYearSection extends Model
{
    use HasFactory;

    protected $table = 'sy_section';

    protected $fillable = [
        'sy_id',
        'course_id',
        'section_id',
        'max_slot_count',
        'current_slot_count',
        'is_slot_full',
        'subjects',
        'status',
        'created_by',
        'updated_by',
    ];

}
