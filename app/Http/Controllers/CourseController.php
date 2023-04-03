<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    //
    public function get(Request $request): JsonResponse
    {            
        $courses = Course::whereNot('status', 'deleted')->orderBy('name')->get();
        return response()->json($courses);
    }

    public function getOne(Request $request, $id): JsonResponse
    {            
        $course = Course::find($id);
        return response()->json($course);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', Rule::unique('course')->where('status' , 'active')],
        ]);

        $course = Course::create([            
            'name' => $request->name,
            'status' => $request->status,
            'email' => $request->email,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,            
        ]);

        return response()->json($course);
    }

    public function update(Request $request, $id): JsonResponse
    {            
        $request->validate([
            'name' => ['required', Rule::unique('course')->where('status' , 'active')->ignore($id)],
        ]);

        Course::where('id', $id)->update([            
            'name' => $request->name,
        ]);
        return response()->json([]);
    }

    public function destroy(Request $request, $id): JsonResponse
    {            
        Course::where('id', $id)->update([
            'status'=> 'deleted',            
        ]);
        return response()->json([]);
    }
}
