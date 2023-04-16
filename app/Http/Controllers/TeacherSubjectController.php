<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;

use App\Models\TeacherSubject;
use App\Models\TeacherSubjectItem;
use App\Models\SchoolYear;
use App\Models\Subject;
use App\Models\Teacher;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

use Carbon\Carbon;

class TeacherSubjectController extends Controller
{

    public function getFormData(Request $request): JsonResponse
    {            
        $schoolYears = SchoolYear::whereNot('status', 'Deleted')
        ->orderBy('year', 'desc')
        ->orderBy('semester', 'desc')
        ->get();

        $teachers = Teacher::select('teacher.*', 'users.is_verified')
        ->join('users', 'teacher.id', '=', 'users.id')
        ->where('is_verified', 1)
        ->whereNot('status', 'Deleted')
        ->orderBy('name')        
        ->get();

        $subjects = Subject::whereNot('status', 'Deleted')->orderBy('name')->get();        

        return response()->json([
            'schoolYears' => $schoolYears,
            'teachers' => $teachers,
            'subjects' => $subjects,
        ]);
    }

    //
    public function get(Request $request, $syId): JsonResponse
    {            
        $teacherSubjects = TeacherSubject::select('teacher_subject.*', 'teacher.name as teacher_name')
            ->join('teacher', 'teacher_subject.teacher_id', '=', 'teacher.id')
            ->where('sy_id', $syId)                       
            ->whereNot('teacher_subject.status', 'Deleted')
            ->orderBy('teacher_name')
            ->get();
        return response()->json($teacherSubjects);
    }

    public function getOne(Request $request, $id): JsonResponse
    {  
        $teacherSubject = TeacherSubject::select('teacher_subject.*', 'teacher.name as teacher_name', 'sy.year', 'sy.semester', 'sy.status as sy_status')
        ->join('sy', 'teacher_subject.sy_id', '=', 'sy.id')
        ->join('teacher', 'teacher_subject.teacher_id', '=', 'teacher.id')
        ->where('teacher_subject.id', $id)
        ->first();

        $teacherSubjectItems = TeacherSubjectItem::select('teacher_subject_id', 'subject.*')
        ->where('teacher_subject_id' , $id)
        ->join('subject', 'teacher_subject_item.subject_id', '=', 'subject.id')
        ->get();

        return response()->json([
            'teacherSubject' => $teacherSubject,
            'teacherSubjectItems' => $teacherSubjectItems
        ]);
    }

    public function store(Request $request): JsonResponse
    {     
        //check if sy is already published
        $syPublished = SchoolYear::where('id', $request->syId)->where('status', 'Published')->first();
        if($syPublished){
            return throw ValidationException::withMessages([
                'syId' => 'School year was already published. Teacher assigning can only be done on active school year status.',
            ]);
        }

        //check if teacher is already assigned to a subejcts
        $teacherExist = TeacherSubject::where('sy_id', $request->syId)
        ->where('teacher_id', $request->teacherId)
        ->where('status', 'Active')->first();

        if($teacherExist){
            return throw ValidationException::withMessages([
                'teacherId' => 'Teacher was already assigned to a subject(s). You can edit the assigned subject(s) instead.',
            ]);
        }

        $teacherSubject = TeacherSubject::create([            
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
                'teacher_subject_id' => $teacherSubject->id,
                'sy_id' => $request->syId,                
                'subject_id' => $subjectId,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        TeacherSubjectItem::insert($data);

        return response()->json([]);
    }

    public function update(Request $request, $id): JsonResponse
    {                
        $teacherSubject = TeacherSubject::where('id', $id)
            ->update([            
                'sy_id' => $request->syId,
                'teacher_id' => $request->teacherId,
                'total_subjects' => $request->totalSubjects,
                'status' => $request->status,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,            
            ]);

        TeacherSubjectItem::where('teacher_subject_id', $id)->delete();

        $data = [];
        foreach ($request->subjectIds as $subjectId) {
            array_push($data, [
                'teacher_subject_id' => $id,
                'sy_id' => $request->syId,                
                'subject_id' => $subjectId,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        TeacherSubjectItem::insert($data);

        return response()->json([]);
    }

    public function destroy(Request $request, $id): JsonResponse
    {            
        TeacherSubject::where('id', $id)->update([
            'status'=> 'Deleted',            
        ]);
        return response()->json([]);
    }
}
