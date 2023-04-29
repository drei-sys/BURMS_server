<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Section;
use App\Models\Subject;
use App\Models\SchoolYear;
use App\Models\SchoolYearSection;
use App\Models\SchoolYearSectionItem;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class SchoolYearSectionController extends Controller
{
    //
    public function getAllBySyId(Request $request, $syId): JsonResponse
    {            
        $schoolYear = SchoolYear::find($syId);
       
        $schoolYearSections = SchoolYearSection::select(
                'sy_section.*',
                'course.name as course_name', 
                'section.name as section_name',
                'subject.code as subject_code',
                'subject.name as subject_name',
                'subject.type as subject_type',
                'subject.unit as subject_unit',
            )
            ->join('course', 'sy_section.course_id', '=', 'course.id')
            ->join('section', 'sy_section.section_id', '=', 'section.id')
            ->join('subject', 'sy_section.subject_id', '=', 'subject.id')
            ->whereNot('sy_section.status', 'Deleted')
            ->where('sy_id', $syId)
            ->orderBy('course.name')
            ->orderBy('section.name')
            ->orderBy('subject.code')
            ->get();           

        return response()->json([
            'schoolYear' => $schoolYear,
            'schoolYearSections' => $schoolYearSections,
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

    public function store(Request $request): Response
    {

        $schoolYear = SchoolYearSection::where('sy_id', $request->syId)        
            ->where('section_id', $request->sectionId)
            ->whereNot('status', 'Deleted')
            ->first();

        if($schoolYear){
            throw ValidationException::withMessages([
                'sectionId' => "Section already exist",
            ]);
        }else{
            $subjectIds = $request->subjectIds;

            $data = [];
            foreach ($subjectIds as $subjectId) {
                array_push($data, [
                    'sy_id'=> $request->syId,
                    'course_id' => $request->courseId,
                    'section_id' => $request->sectionId,
                    'subject_id' => $subjectId,
                    'max_slot_count' => $request->slots,
                    'current_slot_count' => 0,
                    'is_slot_full' => 0,
                    'status' => $request->status,                    
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            SchoolYearSection::insert($data);
            
            return response()->noContent();
        }
    }

    public function destroy(Request $request, $syId, $sectionId): JsonResponse
    {            
        SchoolYearSection::where('sy_id', $syId)
            ->where('section_id', $sectionId)        
            ->delete();
            
        return response()->json([]);
    }
}
