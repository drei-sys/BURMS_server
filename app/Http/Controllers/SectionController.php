<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SectionController extends Controller
{
    //
    public function get(Request $request): JsonResponse
    {            
        $sections = Section::whereNot('status', 'deleted')->orderBy('name')->get();
        return response()->json($sections);
    }

    public function getOne(Request $request, $id): JsonResponse
    {            
        $section = Section::find($id);
        return response()->json($section);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', Rule::unique('section')->where('status' , 'active')],
        ]);

        $section = Section::create([            
            'name' => $request->name,
            'status' => $request->status,
            'email' => $request->email,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,            
        ]);

        return response()->json($section);
    }

    public function update(Request $request, $id): JsonResponse
    {            
        $request->validate([
            'name' => ['required', Rule::unique('section')->where('status' , 'active')->ignore($id)],
        ]);

        Section::where('id', $id)->update([            
            'name' => $request->name,
        ]);
        return response()->json([]);
    }

    public function destroy(Request $request, $id): JsonResponse
    {            
        Section::where('id', $id)->update([
            'status'=> 'deleted',            
        ]);
        return response()->json([]);
    }
}
