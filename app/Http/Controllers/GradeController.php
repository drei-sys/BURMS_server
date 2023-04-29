<?php

namespace App\Http\Controllers;

use App\Models\Grade;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class GradeController extends Controller
{
    //
    public function getAllBySyId(Request $request, $syId): JsonResponse
    {
        $grades = Grade::select('grade.*', 'teacher.lastname as teacher_lastname', 'teacher.firstname as firstname', 'teacher.middlename as teacher_middlename', 'teacher.extname as teacher_extname')
            ->join('teacher', 'grade.teacher_id', '=', 'teacher.id')
            ->where('sy_id', $syId)->get();

        return response()->json($grades);
    }

    public function getAllBySyIdStudentId(Request $request, $syId, $studentId): JsonResponse
    {
        $grades = Grade::select('grade.*', 'teacher.lastname as teacher_lastname', 'teacher.firstname as firstname', 'teacher.middlename as teacher_middlename', 'teacher.extname as teacher_extname')
            ->join('teacher', 'grade.teacher_id', '=', 'teacher.id')
            ->where('sy_id', $syId)
            ->where('student_id', $studentId)
            ->get();

            return response()->json($grades);
    }

    public function getAllByStudentId(Request $request, $studentId): JsonResponse
    {
        $grades = Grade::select('grade.*', 'teacher.lastname as teacher_lastname', 'teacher.firstname as firstname', 'teacher.middlename as teacher_middlename', 'teacher.extname as teacher_extname')
            ->join('teacher', 'grade.teacher_id', '=', 'teacher.id')
            ->where('student_id', $studentId)->get();

            return response()->json($grades);
    }

    public function store(Request $request): Response
    {
        Grade::create([            
            'sy_id' => $request->sy_id,
            'course_id' => $request->course_id,
            'section_id' => $request->section_id,
            'subject_id' => $request->subject_id,
            'student_id' => $request->student_id,
            'teacher_id' => $request->teacher_id,
            'prelim_items' => $request->prelim_items,
            'midterm_items' => $request->midterm_items,
            'final_items' => $request->final_items,
            'prelim_grade' => $request->prelim_grade,
            'midterm_grade' => $request->midterm_grade,
            'final_grade' => $request->final_grade,
            'grade' => $request->grade,
            'rating' => $request->rating,
            'remarks' => $request->remarks,
            'hash'=> Hash::make(Carbon::now()),
            'status' => $request->status,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,            
        ]);

        return response()->noContent();
    }

    public function update(Request $request, $id): Response
    {            

        Grade::find($id)->update([            
            'sy_id' => $request->sy_id,
            'course_id' => $request->course_id,
            'section_id' => $request->section_id,
            'subject_id' => $request->subject_id,
            'student_id' => $request->student_id,
            'teacher_id' => $request->teacher_id,
            'prelim_items' => $request->prelim_items,
            'midterm_items' => $request->midterm_items,
            'final_items' => $request->final_items,
            'prelim_grade' => $request->prelim_grade,
            'midterm_grade' => $request->midterm_grade,
            'final_grade' => $request->final_grade,
            'grade' => $request->grade,
            'rating' => $request->rating,
            'remarks' => $request->remarks,
            'hash'=> Hash::make(Carbon::now()),
            'status' => $request->status,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,  
        ]);
        
        return response()->noResponse([]);
    }
}
