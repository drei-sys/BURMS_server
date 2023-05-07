<?php

namespace App\Http\Controllers;

use App\Models\BlockchainFileUpload;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BlockchainFileUploadController extends Controller
{
    //
    public function getAllReleasedDocs(Request $request): JsonResponse
    {            
        $courses = BlockchainFileUpload::select(
                'blockchain_file_upload.*',
                'student.lastname as student_lastname', 'student.firstname  as student_firstname', 'student.middlename as student_middlename', 'student.extname as student_extname', 'student.course_id', 'student.year_level as student_year_level',
                'course.name as student_course_name'
            )            
            ->join('student', 'blockchain_file_upload.student_id', '=', 'student.id')
            ->join('course', 'student.course_id', '=', 'course.id')
            ->where('category', 'Released Doc')
            ->orderBy('blockchain_file_upload.created_at', 'desc')
            ->get();
        
        return response()->json($courses);
    }

    public function getAllDigitalizedFiles(Request $request): JsonResponse
    {            
        $courses = BlockchainFileUpload::select(
                'blockchain_file_upload.*',
                'student.lastname as student_lastname', 'student.firstname  as student_firstname', 'student.middlename as student_middlename', 'student.extname as student_extname', 'student.course_id', 'student.year_level as student_year_level',
                'course.name as student_course_name'
            )            
            ->join('student', 'blockchain_file_upload.student_id', '=', 'student.id')
            ->join('course', 'student.course_id', '=', 'course.id')
            ->where('category', 'Digitalized File')
            ->orderBy('blockchain_file_upload.created_at', 'desc')
            ->get();
        
        return response()->json($courses);
    }

    public function store(Request $request): Response
    {    
        BlockchainFileUpload::create([            
            'student_id' => $request->student_id,
            'filename' => $request->filename,
            'description' => $request->description,
            'category' => $request->category,
            'pid' => $request->pid,
            'block_hash' => $request->block_hash,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,            
        ]);

        return response()->noContent();
    }
}
