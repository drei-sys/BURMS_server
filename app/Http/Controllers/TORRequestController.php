<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;

use App\Models\TORRequest;
use App\Models\Student;
use App\Models\Course;
use App\Models\EnrollmentItem;
use App\Models\Grade;


use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TORRequestController extends Controller
{
    //
    public function get(Request $request): JsonResponse
    {            
        $torRequests = TORRequest::select('tor_request.*', 'student.lastname as student_lastname', 'student.firstname as student_firstname', 'student.middlename as student_middlename', 'student.extname as student_extname')
        ->join('student', 'tor_request.student_id', '=', 'student.id')
        ->whereNot('tor_request.status', 'Deleted')
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json($torRequests);
    }

    public function getStudentTORRequest(Request $request, $studentId): JsonResponse
    {            
        $torRequests = TORRequest::where('student_id', $studentId)
        ->whereNot('status', 'Deleted')
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json($torRequests);
    }

    public function getGrades(Request $request, $id, $studentId): JsonResponse
    {
        $torRequest = TORRequest::find($id);

        $student = Student::select('student.*', 'course.name as course_name')
        ->join('course', 'student.course_id', '=', 'course.id')
        ->where('student.id', $studentId)
        ->first();

        $courses = Course::all();
        $enrollmentItems = EnrollmentItem::select(
                'enrollment_item.*',
                'sy.year as sy_year', 'sy.semester as sy_semester',
                'student.lastname', 'student.firstname', 'student.middlename', 'student.extname', 'student.user_type', 'student.course_id as student_course_id',
                'course.name as course_name',
                'subject.code as subject_code', 'subject.name as subject_name',
                'section.name as section_name',                    
            )            
            ->join('sy', 'enrollment_item.sy_id', '=', 'sy.id')
            ->join('student', 'enrollment_item.student_id', '=', 'student.id')
            ->join('course', 'enrollment_item.course_id', '=', 'course.id')                
            ->join('subject', 'enrollment_item.subject_id', '=', 'subject.id')                
            ->join('section', 'enrollment_item.section_id', '=', 'section.id')                        
            ->where('student_id', $studentId)
            ->orderBy('student.lastname')
            ->get();

        $grades = $grades = Grade::select('grade.*', 'teacher.lastname as teacher_lastname', 'teacher.firstname as firstname', 'teacher.middlename as teacher_middlename', 'teacher.extname as teacher_extname')
            ->join('teacher', 'grade.teacher_id', '=', 'teacher.id')
            ->where('student_id', $studentId)->get();

        return response()->json([
            'torRequest' => $torRequest,
            'student' => $student,
            'enrollmentItems' => $enrollmentItems,
            'courses' => $courses,
            'grades' => $grades
        ]);
    }

    public function getOne(Request $request, $id): JsonResponse
    {            
        $torRequest = TORRequest::find($id);
        return response()->json($torRequest);
    }

    public function store(Request $request): JsonResponse
    {
        $torRequest = TORRequest::create([            
            'student_id' => auth()->user()->id,
            'reason' => $request->reason,
            'remarks' => $request->remarks,
            'status' => $request->status,            
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,            
        ]);

        return response()->json($torRequest);
    }

    public function update(Request $request, $id): JsonResponse
    {            
        TORRequest::where('id', $id)->update([            
            'reason' => $request->reason,
        ]);
        return response()->json([]);
    }

    public function destroy(Request $request, $id): JsonResponse
    {            
        TORRequest::where('id', $id)->update([
            'status'=> 'Deleted',            
        ]);
        return response()->json([]);
    }

    public function reject(Request $request, $id): JsonResponse
    {            
        TORRequest::where('id', $id)->update([
            'remarks' => $request->rejectReason,
            'status'=> 'Rejected',            
        ]);
        return response()->json([]);
    }
}
