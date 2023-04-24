<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;

use App\Models\EnrollmentItem;
use App\Models\Course;
use App\Models\Grade;


use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    //
    public function getGrades(Request $request, $syId, $id): JsonResponse
    {                    
        $courses = Course::all();
        $enrollmentItems = EnrollmentItem::select(
                'enrollment_item.*',
                'student.lastname', 'student.firstname', 'student.middlename', 'student.extname', 'student.user_type', 'student.course_id as student_course_id',
                'course.name as course_name',
                'subject.code as subject_code', 'subject.name as subject_name',
                'section.name as section_name',                    
            )            
            ->join('student', 'enrollment_item.student_id', '=', 'student.id')
            ->join('course', 'enrollment_item.course_id', '=', 'course.id')                
            ->join('subject', 'enrollment_item.subject_id', '=', 'subject.id')                
            ->join('section', 'enrollment_item.section_id', '=', 'section.id')            
            ->where('sy_id', $syId)
            ->where('student_id', $id)
            ->orderBy('student.lastname')
            ->get();

        $grades = $grades = Grade::select('grade.*', 'teacher.lastname as teacher_lastname', 'teacher.firstname as firstname', 'teacher.middlename as teacher_middlename', 'teacher.extname as teacher_extname')
            ->join('teacher', 'grade.teacher_id', '=', 'teacher.id')
            ->where('student_id', $id)->get();

        return response()->json([            
            'enrollmentItems' => $enrollmentItems,
            'courses' => $courses,
            'grades' => $grades
        ]);
    }
}
