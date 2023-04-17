<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;

use App\Models\Student;
use App\Models\Course;
use App\Models\Section;
use App\Models\Subject;
use App\Models\SchoolYear;
use App\Models\SchoolYearSection;
use App\Models\SchoolYearSectionItem;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

use Illuminate\Validation\ValidationException;

class SchoolYearSectionController extends Controller
{
    //
    public function get(Request $request, $syId): JsonResponse
    {            
        $schoolYear = SchoolYear::find($syId);
        $courses = Course::all();
        $subjects = Subject::all();
        $sections = Section::all();
        $schoolYearSections = SchoolYearSection::whereNot('status', 'Deleted')
        ->where('sy_id', $syId)->get();
        
        $student = Student::select('student.*', 'course.name as course_name')
        ->join('course', 'student.course_id', '=', 'course.id')
        ->where('student.id', auth()->user()->id)
        ->first();

        return response()->json([
            'schoolYear' => $schoolYear,
            'courses' => $courses,
            'subjects' => $subjects,
            'sections' => $sections,
            'schoolYearSections' => $schoolYearSections,            
            'student' => $student 
        ]);
    }

    public function getFormData(Request $request, $syId): JsonResponse
    {            
        $schoolYear = SchoolYear::find($syId);
        $courses = Course::whereNot('status', 'Deleted')->orderBy('name')->get();
        $subjects = Subject::whereNot('status', 'Deleted')->orderBy('name')->get();
        $sections = Section::whereNot('status', 'Deleted')->orderBy('name')->get();
        return response()->json([
            'schoolYear' => $schoolYear,
            'courses' => $courses,
            'subjects' => $subjects,
            'sections' => $sections,
        ]);
    }

    public function store(Request $request): JsonResponse
    {

        $schoolYear = SchoolYearSection::where('sy_id', $request->syId)
        // ->where('course_id', $request->courseId)
        ->where('section_id', $request->sectionId)
        ->first();

        if($schoolYear){
            throw ValidationException::withMessages([
                'sectionId' => "Section already exist",
            ]);
        }else{
            SchoolYearSection::create([
                'sy_id'=> $request->syId,
                'course_id' => $request->courseId,
                'section_id' => $request->sectionId,
                'max_slot_count' => $request->slots,
                'current_slot_count' => 0,
                'is_slot_full' => 0,
                'subjects' => $request->subjectIds,
                'status' => $request->status,
                'email' => $request->email,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);
            return response()->json([]);
        }
    }

    public function destroy(Request $request, $syId, $sectionId): JsonResponse
    {            
        SchoolYearSection::where('sy_id', $syId)
        ->where('section_id', $sectionId)
        ->update(['status'=> 'Deleted',]);
        return response()->json([]);
    }
}
