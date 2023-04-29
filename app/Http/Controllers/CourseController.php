<?php

namespace App\Http\Controllers;

use App\Models\Course;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    //
    public function getAll(Request $request): JsonResponse
    {            
        $courses = Course::whereNot('status', 'Deleted')->orderBy('name')->get();
        
        return response()->json($courses);
    }

    public function getOne(Request $request, $id): JsonResponse
    {            
        $course = Course::whereNot('status', 'Deleted')->find($id);

        return response()->json($course);
    }

    public function store(Request $request): Response
    {
        $request->validate([
            'name' => ['required', Rule::unique('course')->where('status' , 'Active')],
        ]);

        Course::create([            
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
            'name' => ['required', Rule::unique('course')->where('status' , 'Active')->ignore($id)],
        ]);

        Course::find($id)->update([ 'name' => $request->name ]);

        return response()->noContent();
    }

    public function destroy(Request $request, $id): JsonResponse
    {            
        Course::find($id)->update([ 'status'=> 'Deleted' ]);

        return response()->noContent();
    }
}
