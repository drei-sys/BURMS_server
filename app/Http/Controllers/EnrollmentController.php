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

class EnrollmentController extends Controller
{
    //
    // public function get(Request $request): JsonResponse
    // {            
    //     $subjects = Subject::whereNot('status', 'deleted')->orderBy('name')->get();
    //     return response()->json($subjects);
    // }

    // public function getOne(Request $request, $id): JsonResponse
    // {            
    //     $subject = Subject::find($id);
    //     return response()->json($subject);
    // }

    public function store(Request $request): JsonResponse
    {

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

    // public function update(Request $request, $id): JsonResponse
    // {            
    //     $request->validate([
    //         'code' => ['required', Rule::unique('subject')->where('status' , 'active')->ignore($id)],
    //     ]);

    //     Subject::where('id', $id)->update([
    //         'code'=> $request->code,
    //         'name' => $request->name,
    //     ]);
    //     return response()->json([]);
    // }

    // public function destroy(Request $request, $id): JsonResponse
    // {            
    //     Subject::where('id', $id)->update([
    //         'status'=> 'deleted',            
    //     ]);
    //     return response()->json([]);
    // }
}
