<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnnouncementController extends Controller
{
    //
    public function getAll(Request $request): JsonResponse
    {            
        $courses = Announcement::whereNot('status', 'Deleted')->orderBy('name')->get();
        
        return response()->json($courses);
    }

    public function getOne(Request $request, $id): JsonResponse
    {            
        $course = Announcement::whereNot('status', 'Deleted')->find($id);

        return response()->json($course);
    }

    public function store(Request $request): Response
    {
        Announcement::create([            
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,            
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,            
        ]);

        return response()->noContent();
    }

    public function update(Request $request, $id): Response
    {            
        Announcement::find($id)->update([ 'name' => $request->name, 'description' => $request->description, ]);

        return response()->noContent();
    }

    public function destroy(Request $request, $id): Response
    {            
        Announcement::find($id)->update([ 'status'=> 'Deleted' ]);

        return response()->noContent();
    }
}
