<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SchoolYearController extends Controller
{
    //
    public function getAll(Request $request): JsonResponse
    {            
        $schoolYears = SchoolYear::whereNot('status', 'Deleted')
            ->orderBy('year', 'desc')
            ->orderBy('semester', 'desc')
            ->get();

        return response()->json($schoolYears);
    }

    public function getOne(Request $request, $id): JsonResponse
    {            
        $schoolYear = SchoolYear::whereNot('status', 'Deleted')->find($id);

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

    public function store(Request $request): Response
    {
        SchoolYear::create([
            'year'=> $request->year,
            'semester' => $request->semester,
            'status' => $request->status,
            'email' => $request->email,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        return response()->noContent();
    }

    public function update(Request $request, $id): Response
    {            
        SchoolYear::find($id)->update([
            'year'=> $request->year,
            'semester' => $request->semester,
        ]);

        return response()->noContent();
    }

    public function updateSchoolYearStatus(Request $request, $id): Response
    {            
        SchoolYear::find($id)->update([ 'status'=> $request->status ]);

        return response()->noContent();
    }

    public function destroy(Request $request, $id): Response
    {            
        SchoolYear::find($id)->update([ 'status'=> 'Deleted' ]);

        return response()->noContent();
    }
}
