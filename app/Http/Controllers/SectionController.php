<?php

namespace App\Http\Controllers;

use App\Models\Section;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SectionController extends Controller
{
    //
    public function getAll(Request $request): JsonResponse
    {            
        $sections = Section::whereNot('status', 'Deleted')->orderBy('name')->get();
        return response()->json($sections);
    }

    public function getOne(Request $request, $id): JsonResponse
    {            
        $section = Section::whereNot('status', 'Deleted')->find($id);
        
        return response()->json($section);
    }

    public function store(Request $request): Response
    {
        $request->validate([
            'name' => ['required', Rule::unique('section')->where('status' , 'Active')],
        ]);

        Section::create([            
            'name' => $request->name,
            'status' => $request->status,            
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,            
        ]);

        return response()->noContent();
    }

    public function update(Request $request, $id): Response
    {            
        $request->validate([
            'name' => ['required', Rule::unique('section')->where('status' , 'Active')->ignore($id)],
        ]);

        Section::find($id)->update([ 'name' => $request->name ]);
        
        return response()->noContent();
    }

    public function destroy(Request $request, $id): Response
    {            
        Section::where('id', $id)->update([ 'status'=> 'Deleted' ]);
        
        return response()->noContent();
    }
}
