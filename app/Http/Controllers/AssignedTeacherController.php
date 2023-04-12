<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;

use App\Models\AssignedTeacher;
use App\Models\AssignedTeacherItem;
use App\Models\SchoolYear;
use App\Models\Subject;
use App\Models\Teacher;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

use Carbon\Carbon;

class AssignedTeacherController extends Controller
{

    public function getFormData(Request $request): JsonResponse
    {            
        $schoolYears = SchoolYear::whereNot('status', 'deleted')
        ->orderBy('year', 'desc')
        ->orderBy('semester', 'desc')
        ->get();

        $teachers = Teacher::whereNot('status', 'deleted')
        ->orderBy('name')        
        ->get();

        $subjects = Subject::whereNot('status', 'deleted')->orderBy('name')->get();        

        return response()->json([
            'schoolYears' => $schoolYears,
            'teachers' => $teachers,
            'subjects' => $subjects,
        ]);
    }

    //
    public function get(Request $request, $syId): JsonResponse
    {            
        $assignedTeachers = AssignedTeacher::select('assigned_teacher.*', 'teacher.name as teacher_name')
            ->join('teacher', 'assigned_teacher.teacher_id', '=', 'teacher.id')
            ->where('sy_id', $syId)                       
            ->whereNot('assigned_teacher.status', 'deleted')
            ->orderBy('teacher_name')
            ->get();
        return response()->json($assignedTeachers);
    }

    public function getOne(Request $request, $id): JsonResponse
    {  
        $assignedTeacher = AssignedTeacher::select('assigned_teacher.*', 'teacher.name as teacher_name', 'sy.year', 'sy.semester', 'sy.status as sy_status')
        ->join('sy', 'assigned_teacher.sy_id', '=', 'sy.id')
        ->join('teacher', 'assigned_teacher.teacher_id', '=', 'teacher.id')
        ->where('assigned_teacher.id', $id)
        ->first();

        $assignedTeacherItems = AssignedTeacherItem::select('teacher_assigned_id', 'subject.*')
        ->where('teacher_assigned_id' , $id)
        ->join('subject', 'assigned_teacher_item.subject_id', '=', 'subject.id')
        ->get();

        return response()->json([
            'assignedTeacher' => $assignedTeacher,
            'assignedTeacherItems' => $assignedTeacherItems
        ]);
    }

    public function store(Request $request): JsonResponse
    {     
        //check if sy is already published
        $syPublished = SchoolYear::where('id', $request->syId)->where('status', 'published')->first();
        if($syPublished){
            return throw ValidationException::withMessages([
                'syId' => 'School year was already published. Teacher assigning can only be done on active school year status.',
            ]);
        }

        //check if teacher is already assigned to a subejcts
        $teacherExist = AssignedTeacher::where('sy_id', $request->syId)
        ->where('teacher_id', $request->teacherId)
        ->where('status', 'active')->first();

        if($teacherExist){
            return throw ValidationException::withMessages([
                'teacherId' => 'Teacher was already assigned to a subject(s). You can edit the assigned subject(s) instead.',
            ]);
        }

        $assignedTeacher = AssignedTeacher::create([            
            'sy_id' => $request->syId,
            'teacher_id' => $request->teacherId,
            'total_subjects' => $request->totalSubjects,
            'status' => $request->status,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,            
        ]);

        $data = [];
        foreach ($request->subjectIds as $subjectId) {
            array_push($data, [
                'teacher_assigned_id' => $assignedTeacher->id,
                'sy_id' => $request->syId,                
                'subject_id' => $subjectId,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        AssignedTeacherItem::insert($data);

        return response()->json([]);
    }

    public function update(Request $request, $id): JsonResponse
    {                
        $assignedTeacher = AssignedTeacher::where('id', $id)
            ->update([            
                'sy_id' => $request->syId,
                'teacher_id' => $request->teacherId,
                'total_subjects' => $request->totalSubjects,
                'status' => $request->status,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,            
            ]);

        AssignedTeacherItem::where('teacher_assigned_id', $id)->delete();

        $data = [];
        foreach ($request->subjectIds as $subjectId) {
            array_push($data, [
                'teacher_assigned_id' => $id,
                'sy_id' => $request->syId,                
                'subject_id' => $subjectId,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        AssignedTeacherItem::insert($data);

        return response()->json([]);
    }

    public function destroy(Request $request, $id): JsonResponse
    {            
        AssignedTeacher::where('id', $id)->update([
            'status'=> 'deleted',            
        ]);
        return response()->json([]);
    }
}
