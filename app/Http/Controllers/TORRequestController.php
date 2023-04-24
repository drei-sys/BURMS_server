<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use App\Models\TORRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TORRequestController extends Controller
{
    //
    public function get(Request $request): JsonResponse
    {            
        $torRequests = TORRequest::whereNot('status', 'Deleted')->orderBy('created_at', 'desc')->get();
        return response()->json($torRequests);
    }

    public function getOne(Request $request, $id): JsonResponse
    {            
        $torRequest = TORRequest::find($id);
        return response()->json($torRequest);
    }

    public function store(Request $request): JsonResponse
    {
        $torRequest = TORRequest::create([            
            'student_id' => auth()->user()->id,
            'reason' => $request->reason,
            'status' => $request->status,            
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,            
        ]);

        return response()->json($torRequest);
    }

    public function update(Request $request, $id): JsonResponse
    {            
        TORRequest::where('id', $id)->update([            
            'reason' => $request->reason,
        ]);
        return response()->json([]);
    }

    public function destroy(Request $request, $id): JsonResponse
    {            
        TORRequest::where('id', $id)->update([
            'status'=> 'Deleted',            
        ]);
        return response()->json([]);
    }
}
