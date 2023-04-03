<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\NonTeaching;
use App\Models\Registrar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
{
    //
    public function get(Request $request): JsonResponse
    {            
        $users = User::orderBy('name')->get();
        return response()->json($users);
    }        

    public function getOne(Request $request, $id): JsonResponse
    {            
        $user = User::find($id);
        return response()->json($user);
    }

    public function getUserDetails(Request $request): JsonResponse
    {       
        $userType = auth()->user()->user_type;
        $userId = auth()->user()->id;
        if($userType === 3){
            $userDetails = Student::find($userId);
            return response()->json($userDetails);
        }else if($userType === 4){
            $userDetails = Teacher::find($userId);
            return response()->json($userDetails);
        }else if($userType === 5){
            $userDetails = NonTeaching::find($userId);
            return response()->json($userDetails);
        }else if($userType === 6){
            $userDetails = Registrar::find($userId);
            return response()->json($userDetails);
        }else{
            return response()->json([]);
        }
    }

    public function getProfileEditApprovals(Request $request): JsonResponse
    {                                        
        $students = Student::where('status', 'for_approval')->orderBy('name')->get();
        $teachers = Teacher::where('status', 'for_approval')->orderBy('name')->get();
        $nonTeachings = NonTeaching::where('status', 'for_approval')->orderBy('name')->get();
        $registrars = Registrar::where('status', 'for_approval')->orderBy('name')->get();
        $users = [...$students, ...$teachers, ...$nonTeachings, ...$registrars];    
        return response()->json($users);
    }

    public function verify(Request $request, $id): JsonResponse
    {                    
        User::where('id', $id)->update([
            'is_verified'=> 1,            
        ]);
        return response()->json([]);
    }

    public function updateUserDetailsStatus(Request $request, $id, $userType): JsonResponse
    {                            
        if($userType === '3'){
            Student::where('id', $id)->update([
                'status'=> $request->status,            
            ]);
            return response()->json([]);
        }else if($userType === '4') {
            Teacher::where('id', $id)->update([
                'status'=> $request->status,            
            ]);
            return response()->json([]);
        }else if($userType === '5') {
            NonTeaching::where('id', $id)->update([
                'status'=> $request->status,            
            ]);
            return response()->json([]);
        }else if($userType === '6') {
            Registrar::where('id', $id)->update([
                'status'=> $request->status,            
            ]);
            return response()->json([]);
        }else{
            return response()->json($userType);
        }
    }

    public function updateUserDetails(Request $request, $id): JsonResponse
    {              
        $userType = auth()->user()->user_type;                  
        if($userType === 3){
            Student::where('id', $id)->update([
                'name'=> $request->name,            
                'hash'=> Hash::make(Carbon::now()),            
                'status'=> 'uneditable',            
            ]);
            return response()->json([]);
        }else if($userType === 4) {
            Teacher::where('id', $id)->update([
                'name'=> $request->name,            
                'hash'=> Hash::make(Carbon::now()),            
                'status'=> 'uneditable',            
            ]);
            return response()->json([]);
        }else if($userType === 5) {
            NonTeaching::where('id', $id)->update([
                'name'=> $request->name,            
                'hash'=> Hash::make(Carbon::now()),            
                'status'=> 'uneditable',            
            ]);
            return response()->json([]);
        }else if($userType === 6) {
            Registrar::where('id', $id)->update([
                'name'=> $request->name,            
                'hash'=> Hash::make(Carbon::now()),            
                'status'=> 'uneditable',            
            ]);
            return response()->json([]);
        }else{
            return response()->json([]);
        }
    }

}
