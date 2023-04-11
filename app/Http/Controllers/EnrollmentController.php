<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;

use App\Models\Subject;
use App\Models\SchoolYearSection;
use App\Models\Enrollment;
use App\Models\EnrollmentItem;


use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Validation\ValidationException;

use Carbon\Carbon;

class EnrollmentController extends Controller
{
    //
    public function get(Request $request): JsonResponse
    {            
        $enrollments = Enrollment::select('enrollment.*', 'student.name as student_name', 'sy.year', 'sy.semester')
            ->join('sy', 'enrollment.sy_id', '=', 'sy.id')
            ->join('student', 'enrollment.student_id', '=', 'student.id')
            ->orderBy('sy_id', 'desc')->get();
        return response()->json($enrollments);
    }

    public function getStudentEnrollment(Request $request, $studentId): JsonResponse
    {            
        $enrollments = Enrollment::where('student_id', $studentId)
            ->select('enrollment.*', 'sy.year', 'sy.semester')
            ->join('sy', 'enrollment.sy_id', '=', 'sy.id')
            ->orderBy('sy_id', 'desc')->get();
        return response()->json($enrollments);
    }

    public function getEnrollmentItems(Request $request, $enrollmentId): JsonResponse
    {       
        $enrollment = Enrollment::find($enrollmentId);
        $enrollmentItems = EnrollmentItem::where('enrollment_id', $enrollmentId)
            ->select('enrollment_item.*', 'sy.year', 'sy.semester', 'course.name as course_name', 'section.name as section_name', 'subject.name as subject_name', 'subject.code as subject_code')
            ->join('sy', 'enrollment_item.sy_id', '=', 'sy.id')
            ->join('course', 'enrollment_item.course_id', '=', 'course.id')
            ->join('section', 'enrollment_item.section_id', '=', 'section.id')
            ->join('subject', 'enrollment_item.subject_id', '=', 'subject.id')
            ->get();
        return response()->json([
            'enrollment' => $enrollment,
            'enrollmentItems' => $enrollmentItems
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        //check if student is already enrolled
        $enrollmentExist = Enrollment::where('sy_id', $request->sy_id)
            ->where('student_id', auth()->user()->id)
            ->whereNot('status', 'rejected')->first();

        if($enrollmentExist){
            return throw ValidationException::withMessages([
                'section' => 'You already have a pending enrollment. You can browse it on Enrollments page.',
            ]);
        }

        //check each section if its full (schoolYearSections)
        $fullySlotSections = SchoolYearSection::where('is_slot_full', 1)
            ->where('sy_id', $request->sy_id)->get();
        $fullySlotSectionIds = [];
        foreach ($fullySlotSections as $fullySlotSection) {
            array_push($fullySlotSectionIds, $fullySlotSection["section_id"]);
        }

        $enrollmentItems = $request->items;
        $fullySlotSection = "";
        foreach ($enrollmentItems as $enrollmentItem) {
            if(in_array($enrollmentItem["section_id"], $fullySlotSectionIds)){
                $fullySlotSection = $enrollmentItem["section_name"];
                break;
            }
        }

        if($fullySlotSection !== ""){
            return throw ValidationException::withMessages([
                'section' => $fullySlotSection . ' section slots was full. Please select different section.',
            ]);
        }

        //insert data to enrollment and enrollment items
        $enrollment = Enrollment::create([
            'student_id'=> auth()->user()->id,
            'sy_id' => $request->sy_id,
            'status' => $request->status,
            'remarks' => '',
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        $data = [];
        foreach ($enrollmentItems as $enrollmentItem) {
            array_push($data, [
                'enrollment_id' => $enrollment->id,
                'sy_id' => $enrollmentItem['sy_id'],
                'course_id' => $enrollmentItem['course_id'],
                'section_id' => $enrollmentItem['section_id'],
                'subject_id' => $enrollmentItem['subject_id'],
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        EnrollmentItem::insert($data);

        //increaase slots count (schoolYearSections)
        foreach ($enrollmentItems as $enrollmentItem) {
            $schoolYearSection = SchoolYearSection::where('sy_id', $enrollmentItem['sy_id'])
                ->where('section_id', $enrollmentItem['section_id'])->first();

            $currentSlotCount = $schoolYearSection->current_slot_count;
            $maxSlotCount = $schoolYearSection->max_slot_count;
            $isSlotFull = $schoolYearSection->is_slot_full;

            $currentSlotCount += 1;

            if($currentSlotCount === $maxSlotCount){
                $isSlotFull = 1;
            }

            SchoolYearSection::where('sy_id', $enrollmentItem['sy_id'])
                ->where('section_id', $enrollmentItem['section_id'])
                ->update(['current_slot_count' => $currentSlotCount, 'is_slot_full' => $isSlotFull]);
        }

        return response()->json([]);
    }

    public function approve(Request $request, $id): JsonResponse
    {            
        Enrollment::where('id', $id)->update([
            'status'=> 'approved',            
        ]);
        return response()->json([]);
    }

    public function reject(Request $request, $id): JsonResponse
    {          
        //decrease slots
        $enrollmentItems = EnrollmentItem::where('enrollment_id', $id)->get();

        foreach ($enrollmentItems as $enrollmentItem) {
            $schoolYearSection = SchoolYearSection::where('sy_id', $enrollmentItem['sy_id'])
                ->where('section_id', $enrollmentItem['section_id'])->first();

            $currentSlotCount = $schoolYearSection->current_slot_count;
            $maxSlotCount = $schoolYearSection->max_slot_count;
            $isSlotFull = $schoolYearSection->is_slot_full;

            $currentSlotCount -= 1;

            if($currentSlotCount !== $maxSlotCount){
                $isSlotFull = 0;
            }

            SchoolYearSection::where('sy_id', $enrollmentItem['sy_id'])
                ->where('section_id', $enrollmentItem['section_id'])
                ->update(['current_slot_count' => $currentSlotCount, 'is_slot_full' => $isSlotFull]);
        }
        
        Enrollment::where('id', $id)->update([
            'status'=> 'rejected',            
        ]);
        return response()->json($enrollmentItems);
    }
}
