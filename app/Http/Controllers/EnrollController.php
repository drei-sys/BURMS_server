<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnrollController extends Controller
{
    //
    public function get(Request $request): JsonResponse
    {            
        $schoolYear = SchoolYear::where('status', 'published')
        ->orderBy('year', 'desc')
        ->orderBy('semester', 'desc')
        ->first();
        return response()->json($schoolYear);
    }

    // public function getOne(Request $request, $id): JsonResponse
    // {            
    //     $subject = Enroll::find($id);
    //     return response()->json($subject);
    // }

    // public function store(Request $request): JsonResponse
    // {
    //     $request->validate([
    //         'code' => ['required', Rule::unique('subject')->where('status' , 'active')],
    //     ]);

    //     $subject = Enroll::create([
    //         'code'=> $request->code,
    //         'name' => $request->name,
    //         'status' => $request->status,
    //         'email' => $request->email,
    //         'created_by' => auth()->user()->id,
    //         'updated_by' => auth()->user()->id,            
    //     ]);

    //     return response()->json($subject);
    // }

    // public function update(Request $request, $id): JsonResponse
    // {            
    //     $request->validate([
    //         'code' => ['required', Rule::unique('subject')->where('status' , 'active')->ignore($id)],
    //     ]);

    //     Enroll::where('id', $id)->update([
    //         'code'=> $request->code,
    //         'name' => $request->name,
    //     ]);
    //     return response()->json([]);
    // }

    // public function destroy(Request $request, $id): JsonResponse
    // {            
    //     Enroll::where('id', $id)->update([
    //         'status'=> 'deleted',            
    //     ]);
    //     return response()->json([]);
    // }
}
