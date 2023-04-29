<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\EnrollmentItem;
use App\Models\TeacherSubject;
use App\Models\TeacherSubjectItem;
use App\Models\TORRequest;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnrollmentItemController extends Controller
{
    //
    public function getAllBySyIdTeacherId(Request $request, $syId, $teacherId): JsonResponse
    {                    
        $teacherSubject = TeacherSubject::whereNot('status', 'Deleted')
            ->where('sy_id', $syId)
            ->where('teacher_id', $teacherId)
            ->first();

        $teacherSubjectItems = [];
        $enrollments = [];
        $enrollmentItems = [];        
        $grades = [];

        if($teacherSubject){

            $teacherSubjectItems = TeacherSubjectItem::select('teacher_subject_item.*', 'subject.code', 'subject.name')
                ->join('subject', 'teacher_subject_item.subject_id', '=', 'subject.id')
                ->where('teacher_subject_id', $teacherSubject->id)
                ->get();

            $subjectIds = [];
            foreach ($teacherSubjectItems as $teacherSubjectItem) {
                array_push($subjectIds, $teacherSubjectItem["subject_id"]);
            }
            
            $enrollments = Enrollment::select(
                    'enrollment.*', 'sy.year as sy_year', 'sy.semester as sy_semester',
                    'student.lastname as student_lastname',
                    'student.firstname as student_firstname',
                    'student.middlename as student_middlename',
                    'student.extname as student_extname',
                    'student.user_type as student_user_type',
                    'student.course_id as student_course_id',
                    'course.name as student_course_name'
                )
                ->join('sy', 'enrollment.sy_id', '=', 'sy.id')
                ->join('student', 'enrollment.student_id', '=', 'student.id')
                ->join('course', 'student.course_id', '=', 'course.id')
                ->where('enrollment.sy_id', $syId)     
                ->where('enrollment.status', 'Enrolled')
                ->orderBy('student.lastname')
                ->get();

            $enrollmentIds = [];
            foreach ($enrollments as $enrollment) {
                array_push($enrollmentIds, $enrollment["id"]);
            }

            $enrollmentItems = EnrollmentItem::select(
                    'enrollment_item.*',
                    'course.name as course_name',
                    'section.name as section_name',
                    'subject.code as subject_code', 'subject.name as subject_name', 'subject.unit as subject_unit',
                )                                
                ->join('course', 'enrollment_item.course_id', '=', 'course.id')
                ->join('section', 'enrollment_item.section_id', '=', 'section.id')                            
                ->join('subject', 'enrollment_item.subject_id', '=', 'subject.id')                
                ->whereIn('enrollment_item.enrollment_id', $enrollmentIds)
                ->whereIn('enrollment_item.subject_id', $subjectIds)                
                ->get();            
        }

        return response()->json([
            'teacherSubject' => $teacherSubject,
            'teacherSubjectItems' =>  $teacherSubjectItems,
            'enrollments'  => $enrollments,
            'enrollmentItems' => $enrollmentItems,                        
        ]);
    }

    public function getAllBySyIdStudentId(Request $request, $syId, $studentId): JsonResponse
    {
        $enrollment = Enrollment::select(
            'enrollment.*', 'sy.year as sy_year', 'sy.semester as sy_semester',
            'student.lastname as student_lastname',
            'student.firstname as student_firstname',
            'student.middlename as student_middlename',
            'student.extname as student_extname',
            'student.user_type as student_user_type',
            'student.course_id as student_course_id',
            'course.name as student_course_name'
        )
            ->join('sy', 'enrollment.sy_id', '=', 'sy.id')
            ->join('student', 'enrollment.student_id', '=', 'student.id')
            ->join('course', 'student.course_id', '=', 'course.id')
            ->where('enrollment.sy_id', $syId)
            ->where('enrollment.student_id', $studentId)
            ->where('enrollment.status', 'Enrolled')
            ->orderBy('student.lastname')
            ->first();

        $enrollmentItems = [];
        if($enrollment){
            $enrollmentItems = EnrollmentItem::select(
                'enrollment_item.*',
                'course.name as course_name',
                'section.name as section_name',
                'subject.code as subject_code', 'subject.name as subject_name', 'subject.unit as subject_unit',
            )                                
                ->join('course', 'enrollment_item.course_id', '=', 'course.id')
                ->join('section', 'enrollment_item.section_id', '=', 'section.id')                            
                ->join('subject', 'enrollment_item.subject_id', '=', 'subject.id')                
                ->where('enrollment_id', $enrollment->id)
                ->get();
        }

        return response()->json([            
            'enrollment' => $enrollment,
            'enrollmentItems' => $enrollmentItems,
        ]);
    }

    public function getAllByTORId(Request $request, $torId): JsonResponse
    {

        $torRequest = TORRequest::whereNot('status', 'Deleted')->find($torId);

        $enrollments = [];
        $enrollmentItems = [];

        if($torRequest){
            $enrollments = Enrollment::select(
                'enrollment.*', 'sy.year as sy_year', 'sy.semester as sy_semester',
                'student.lastname as student_lastname',
                'student.firstname as student_firstname',
                'student.middlename as student_middlename',
                'student.extname as student_extname',
                'student.user_type as student_user_type',
                'student.course_id as student_course_id',
                'course.name as student_course_name'
            )
                ->join('sy', 'enrollment.sy_id', '=', 'sy.id')
                ->join('student', 'enrollment.student_id', '=', 'student.id')
                ->join('course', 'student.course_id', '=', 'course.id')
                ->where('enrollment.student_id', $torRequest->student_id)     
                ->where('enrollment.status', 'Enrolled')
                ->orderBy('student.lastname')
                ->get();

            $enrollmentIds = [];
            foreach ($enrollments as $enrollment) {
                array_push($enrollmentIds, $enrollment["id"]);
            }

            $enrollmentItems = EnrollmentItem::select(
                'enrollment_item.*',
                'course.name as course_name',
                'section.name as section_name',
                'subject.code as subject_code', 'subject.name as subject_name' , 'subject.unit as subject_unit',
            )                                
                ->join('course', 'enrollment_item.course_id', '=', 'course.id')
                ->join('section', 'enrollment_item.section_id', '=', 'section.id')                            
                ->join('subject', 'enrollment_item.subject_id', '=', 'subject.id')                
                ->whereIn('enrollment_item.enrollment_id', $enrollmentIds)            
                ->get();
        }

        return response()->json([    
            'torRequest' => $torRequest,        
            'enrollments' => $enrollments,
            'enrollmentItems' => $enrollmentItems,
        ]);
    }
}
