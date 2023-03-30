<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    //
    public function get(Request $request): JsonResponse
    {            
        $subjects = Subject::whereNot('status', 'deleted')->orderBy('name')->get();
        return response()->json($subjects);
    }

    public function getOne(Request $request, $id): JsonResponse
    {            
        $subject = Subject::find($id);
        return response()->json($subject);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'code' => ['required', Rule::unique('subject')->where('status' , 'active')],
        ]);

        $subject = Subject::create([
            'code'=> $request->code,
            'name' => $request->name,
            'status' => $request->status,
            'email' => $request->email,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,            
        ]);

        return response()->json($subject);
    }

    public function update(Request $request, $id): JsonResponse
    {            
        $request->validate([
            'code' => ['required', Rule::unique('subject')->where('status' , 'active')->ignore($id)],
        ]);

        Subject::where('id', $id)->update([
            'code'=> $request->code,
            'name' => $request->name,
        ]);
        return response()->json([]);
    }

    public function destroy(Request $request, $id): JsonResponse
    {            
        Subject::where('id', $id)->update([
            'status'=> 'deleted',            
        ]);
        return response()->json([]);
    }
}
