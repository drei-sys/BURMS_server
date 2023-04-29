<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Student;
use App\Models\SchoolYearSection;
use App\Models\Enrollment;
use App\Models\EnrollmentItem;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class EnrollmentController extends Controller
{
    //
    public function getAll(Request $request): JsonResponse
    {            
        $enrollments = Enrollment::select('enrollment.*', 'student.lastname', 'student.firstname', 'student.middlename', 'student.extname', 'sy.year', 'sy.semester')
            ->join('sy', 'enrollment.sy_id', '=', 'sy.id')
            ->join('student', 'enrollment.student_id', '=', 'student.id')
            ->orderBy('sy_id', 'desc')->get();
            
        return response()->json($enrollments);
    }

    public function getAllByStudentId(Request $request, $studentId): JsonResponse
    {            
        $enrollments = Enrollment::where('student_id', $studentId)
            ->select('enrollment.*', 'sy.year', 'sy.semester')
            ->join('sy', 'enrollment.sy_id', '=', 'sy.id')
            ->orderBy('sy_id', 'desc')
            ->get();

        return response()->json($enrollments);
    }

    public function getOne(Request $request, $id): JsonResponse
    {       

        $enrollment = Enrollment::select('enrollment.*', 'sy.year as sy_year', 'sy.semester as sy_semester')
            ->join('sy', 'enrollment.sy_id', '=', 'sy.id')
            ->where('enrollment.id', $id)
            ->first();

        $student = null;
        $enrollmentItems= [];

        if($enrollment){
            $student = Student::select('student.*', 'course.name as course_name')
                ->join('course', 'student.course_id', '=', 'course.id')
                ->where('student.id', $enrollment->student_id)
                ->first();

            $enrollmentItems = EnrollmentItem::select('enrollment_item.*', 'course.name as course_name', 'section.name as section_name', 'subject.name as subject_name', 'subject.code as subject_code', 'subject.unit as subject_unit')            
                ->join('course', 'enrollment_item.course_id', '=', 'course.id')
                ->join('section', 'enrollment_item.section_id', '=', 'section.id')
                ->join('subject', 'enrollment_item.subject_id', '=', 'subject.id')
                ->where('enrollment_id', $id)
                ->get();
        }

        return response()->json([
            'enrollment' => $enrollment,            
            'enrollmentItems' => $enrollmentItems,
            'student' => $student
        ]);
    }

    public function store(Request $request): Response
    {
        //check if student is already enrolled
        $enrollmentExist = Enrollment::where('sy_id', $request->sy_id)
            ->where('student_id', auth()->user()->id)
            ->whereNot('status', 'Rejected')->first();

        if($enrollmentExist){
            return throw ValidationException::withMessages([
                'section' => 'You already have an enrollment. You can browse it on Enrollments page.',
            ]);
        }

        //check each section's subject if its slot is full (schoolYearSections)
        $fullySlotItems = SchoolYearSection::where('is_slot_full', 1)
            ->where('sy_id', $request->sy_id)->get();
            
        $fullySlotSectionIds = [];
        $fullySlotSubjectIds = [];

        foreach ($fullySlotItems as $fullySlotItem) {
            array_push($fullySlotSectionIds, $fullySlotItem["section_id"]);
            array_push($fullySlotSubjectIds, $fullySlotItem["subject_id"]);
        }
        

        $enrollmentItems = $request->items;
        $fullySlotSection = "";
        $fullySlotSubject = "";
        foreach ($enrollmentItems as $enrollmentItem) {
            if(in_array($enrollmentItem["section_id"], $fullySlotSectionIds) && in_array($enrollmentItem["subject_id"], $fullySlotSubjectIds)){
                $fullySlotSection = $enrollmentItem["section_name"];
                $fullySlotSubject = $enrollmentItem["subject_name"];
                break;
            }
        }

        if($fullySlotSection !== ""){
            return throw ValidationException::withMessages([
                'section' => $fullySlotSection . ' section slots for subject ' . $fullySlotSubject . ' was already full. Please select different section.',
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

        //increase slots count (schoolYearSections)
        foreach ($enrollmentItems as $enrollmentItem) {

            $syId = $enrollment->sy_id;
            $courseId = $enrollmentItem['course_id'];
            $sectionId = $enrollmentItem['section_id'];
            $subjectId = $enrollmentItem['subject_id'];

            $schoolYearSection = SchoolYearSection::where('sy_id', $syId)
                ->where('course_id', $courseId)
                ->where('section_id', $sectionId)
                ->where('subject_id', $subjectId)
                ->first();

            $currentSlotCount = $schoolYearSection->current_slot_count;
            $maxSlotCount = $schoolYearSection->max_slot_count;
            $isSlotFull = $schoolYearSection->is_slot_full;

            $currentSlotCount += 1;

            if($currentSlotCount === $maxSlotCount){
                $isSlotFull = 1;
            }

            SchoolYearSection::where('sy_id', $syId)
                ->where('course_id', $courseId)
                ->where('section_id', $sectionId)
                ->where('subject_id', $subjectId)
                ->update(['current_slot_count' => $currentSlotCount, 'is_slot_full' => $isSlotFull]);
        }

        return response()->noContent();
    }

    public function updateEnrollmentStatus(Request $request, $id): Response
    {            

        if($request->status === "Enrolled"){

            Enrollment::find($id)->update([ 'status'=> $request->status ]);

        }else if($request->status === "Rejected"){

            $enrollment = Enrollment::find($id);

            //decrease slots
            $enrollmentItems = EnrollmentItem::where('enrollment_id', $id)->get();

            foreach ($enrollmentItems as $enrollmentItem) {

                $syId = $enrollment->sy_id;
                $courseId = $enrollmentItem['course_id'];
                $sectionId = $enrollmentItem['section_id'];
                $subjectId = $enrollmentItem['subject_id'];

                $schoolYearSection = SchoolYearSection::where('sy_id', $syId)
                    ->where('course_id', $courseId)
                    ->where('section_id', $sectionId)
                    ->where('subject_id', $subjectId)
                    ->first();

                $currentSlotCount = $schoolYearSection->current_slot_count;
                $maxSlotCount = $schoolYearSection->max_slot_count;
                $isSlotFull = $schoolYearSection->is_slot_full;

                $currentSlotCount -= 1;

                if($currentSlotCount !== $maxSlotCount){
                    $isSlotFull = 0;
                }

                SchoolYearSection::where('sy_id', $syId)
                ->where('course_id', $courseId)
                ->where('section_id', $sectionId)
                ->where('subject_id', $subjectId)
                ->update(['current_slot_count' => $currentSlotCount, 'is_slot_full' => $isSlotFull]);
            }

            Enrollment::find($id)->update([ 'status'=> $request->status ]);
        }

        return response()->noContent();
    }
}
