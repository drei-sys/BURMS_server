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
    public function getOne(Request $request, $id): JsonResponse
    {
        $student = Student::select('student.*', 'course.name as course_name')
            ->join('course', 'student.course_id', '=', 'course.id')
            ->where('student.id', $id)
            ->first();

        return response()->json($student);
    }
}
