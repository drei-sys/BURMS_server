<?php

namespace App\Http\Controllers;

use App\Models\TORRequest;
use App\Models\Student;
use App\Models\Course;
use App\Models\EnrollmentItem;
use App\Models\Grade;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TORRequestController extends Controller
{
    //
    public function getAll(Request $request): JsonResponse
    {            
        $torRequests = TORRequest::select('tor_request.*', 'student.lastname as student_lastname', 'student.firstname as student_firstname', 'student.middlename as student_middlename', 'student.extname as student_extname')
            ->join('student', 'tor_request.student_id', '=', 'student.id')
            ->whereNot('tor_request.status', 'Deleted')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($torRequests);
    }

    public function getAllApproved(Request $request): JsonResponse
    {            
        $torRequests = TORRequest::select('tor_request.*', 'student.lastname as student_lastname', 'student.firstname as student_firstname', 'student.middlename as student_middlename', 'student.extname as student_extname')
            ->join('student', 'tor_request.student_id', '=', 'student.id')
            ->where('tor_request.status', 'Approved')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($torRequests);
    }

    public function getAllByStudentId(Request $request, $studentId): JsonResponse
    {            
        $torRequests = TORRequest::where('student_id', $studentId)
            ->whereNot('status', 'Deleted')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($torRequests);
    }    

    public function getOne(Request $request, $id): JsonResponse
    {            
        $torRequest = TORRequest::whereNot('status', 'Deleted')->find($id);

        return response()->json($torRequest);
    }

    public function store(Request $request): Response
    {
        TORRequest::create([            
            'student_id' => auth()->user()->id,
            'reason' => $request->reason,
            'remarks' => $request->remarks,
            'status' => $request->status,            
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,            
        ]);

        return response()->noContent();
    }

    public function update(Request $request, $id): Response
    {            
        TORRequest::find($id)->update([ 'reason' => $request->reason ]);
        
        return response()->noContent();
    }

    public function destroy(Request $request, $id): Response
    {            
        TORRequest::find($id)->update([ 'status'=> 'Deleted' ]);

        return response()->noContent();
    }

    public function reject(Request $request, $id): Response
    {            
        TORRequest::find($id)->update([
            'remarks' => $request->rejectReason,
            'status'=> 'Rejected',            
        ]);

        return response()->noContent();
    }
}
