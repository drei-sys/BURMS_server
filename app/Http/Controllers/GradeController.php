<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class GradeController extends Controller
{
    //
    public function get(Request $request): JsonResponse
    {            
        $grades = Grade::whereNot('status', 'Deleted')->orderBy('name')->get();
        return response()->json($grades);
    }

    public function getOne(Request $request, $id): JsonResponse
    {            
        $grade = Grade::find($id);
        return response()->json($grade);
    }

    public function store(Request $request): JsonResponse
    {
        $grade = Grade::create([            
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
            'equivalent' => $request->equivalent,
            'remarks' => $request->remarks,
            'hash'=> Hash::make(Carbon::now()),
            'status' => $request->status,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,            
        ]);

        return response()->json($grade);
    }

    public function update(Request $request, $id): JsonResponse
    {            

        Grade::where('id', $id)->update([            
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
            'equivalent' => $request->equivalent,
            'remarks' => $request->remarks,
            'hash'=> Hash::make(Carbon::now()),
            'status' => $request->status,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,  
        ]);
        return response()->json([]);
    }
}
