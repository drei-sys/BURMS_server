<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Enrollment;
use App\Models\EnrollmentItem;
use App\Models\Course;
use App\Models\Grade;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    //
    public function getAll(Request $request): JsonResponse
    {
        $students = Student::select('student.*', 'course.name as course_name', 'users.status as user_status')
            ->join('course', 'student.course_id', '=', 'course.id')
            ->join('users', 'student.id', '=', 'users.id')
            ->where('users.status', 'Verified')
            ->orderBy('student.lastname')
            ->get();

        return response()->json($students);
    }


    public function getOne(Request $request, $id): JsonResponse
    {
        $student = Student::select('student.*', 'course.name as course_name')
            ->join('course', 'student.course_id', '=', 'course.id')
            ->where('student.id', $id)
            ->first();

        return response()->json($student);
    }
}
