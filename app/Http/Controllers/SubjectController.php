<?php

namespace App\Http\Controllers;

use App\Models\Subject;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    //
    public function getAll(Request $request): JsonResponse
    {            
        $subjects = Subject::whereNot('status', 'Deleted')->orderBy('name')->get();
        
        return response()->json($subjects);
    }

    public function getOne(Request $request, $id): JsonResponse
    {            
        $subject = Subject::whereNot('status', 'Deleted')->find($id);

        return response()->json($subject);
    }

    public function store(Request $request): Response
    {
        $request->validate([
            'code' => ['required', Rule::unique('subject')->where('status' , 'Active')],
        ]);

        Subject::create([
            'code'=> $request->code,
            'name' => $request->name,
            'unit' => $request->unit,
            'status' => $request->status,            
            'type' => $request->type,            
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,            
        ]);

        return response()->noContent();
    }

    public function update(Request $request, $id): Response
    {            
        $request->validate([
            'code' => ['required', Rule::unique('subject')->where('status' , 'Active')->ignore($id)],
        ]);

        Subject::find($id)->update([
            'code'=> $request->code,
            'name' => $request->name,
            'unit' => $request->unit,
            'type' => $request->type,
        ]);

        return response()->noContent();
    }

    public function destroy(Request $request, $id): Response
    {            
        Subject::find($id)->update([ 'status'=> 'Deleted' ]);
        
        return response()->noContent();
    }
}
