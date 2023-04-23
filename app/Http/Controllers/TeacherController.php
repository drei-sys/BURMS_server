<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;

use App\Models\TeacherSubject;
use App\Models\TeacherSubjectItem;
use App\Models\EnrollmentItem;
use App\Models\Course;
use App\Models\Grade;


use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    //
    public function getStudents(Request $request, $syId, $id): JsonResponse
    {            
        $teacherSubject = TeacherSubject::whereNot('status', 'Deleted')
            ->where('sy_id', $syId)
            ->where('teacher_id', $id)
            ->first();

        $teacherSubjectItems = [];
        if($teacherSubject){

            $teacherSubjectItems = TeacherSubjectItem::select('teacher_subject_item.*', 'subject.code', 'subject.name')
                ->join('subject', 'teacher_subject_item.subject_id', '=', 'subject.id')
                ->where('teacher_subject_id', $teacherSubject->id)
                ->get();

            $subjectIds = [];
            foreach ($teacherSubjectItems as $teacherSubjectItem) {
                array_push($subjectIds, $teacherSubjectItem["subject_id"]);
            }

            $courses = Course::all();

            $enrollmentItems = EnrollmentItem::select(
                    'enrollment_item.*', 'enrollment.status',
                    'student.lastname', 'student.firstname', 'student.middlename', 'student.extname', 'student.user_type', 'student.course_id as student_course_id',
                    'course.name as course_name',
                    'subject.code as subject_code', 'subject.name as subject_name',
                    'section.name as section_name',                    
                )
                ->join('enrollment', 'enrollment_item.enrollment_id', '=', 'enrollment.id')                
                ->join('student', 'enrollment_item.student_id', '=', 'student.id')
                ->join('course', 'enrollment_item.course_id', '=', 'course.id')                
                ->join('subject', 'enrollment_item.subject_id', '=', 'subject.id')                
                ->join('section', 'enrollment_item.section_id', '=', 'section.id')
                ->where('enrollment.status', 'Enrolled')
                ->whereIn('enrollment_item.subject_id', $subjectIds)
                ->orderBy('student.lastname')
                ->get();

            $grades = Grade::where('sy_id', $syId)->get();

        }

        return response()->json([
            'teacherSubject' => $teacherSubject,
            'teacherSubjectItems' =>  $teacherSubjectItems,
            'enrollmentItems' => $enrollmentItems,
            'courses' => $courses,
            'grades' => $grades
        ]);
    }
}
