<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SchoolYearController extends Controller
{
    //
    public function get(Request $request): JsonResponse
    {            
        $schoolYears = SchoolYear::whereNot('status', 'Deleted')
                        ->orderBy('year', 'desc')
                        ->orderBy('semester', 'desc')
                        ->get();
        return response()->json($schoolYears);
    }

    public function getOne(Request $request, $id): JsonResponse
    {            
        $schoolYear = SchoolYear::find($id);
        return response()->json($schoolYear);
    }

    public function getOnePublished(Request $request): JsonResponse
    {            
        $schoolYear = SchoolYear::where('status', 'Published')
        ->orderBy('year', 'desc')
        ->orderBy('semester', 'desc')
        ->first();

        return response()->json($schoolYear);
    }

    public function store(Request $request): JsonResponse
    {
        $schoolYear = SchoolYear::create([
            'year'=> $request->year,
            'semester' => $request->semester,
            'status' => $request->status,
            'email' => $request->email,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        return response()->json($schoolYear);
    }

    public function update(Request $request, $id): JsonResponse
    {            
        SchoolYear::where('id', $id)->update([
            'year'=> $request->year,
            'semester' => $request->semester,
        ]);
        return response()->json([]);
    }

    public function updateStatus(Request $request, $id): JsonResponse
    {            
        SchoolYear::where('id', $id)->update([
            'status'=> $request->status,            
        ]);
        return response()->json([]);
    }

    public function destroy(Request $request, $id): JsonResponse
    {            
        SchoolYear::where('id', $id)->update([
            'status'=> 'Deleted',            
        ]);
        return response()->json([]);
    }
}
