<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\NonTeaching;
use App\Models\Registrar;
use App\Models\Dean;
use App\Models\DeptChair;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
{
    //
    public function get(Request $request): JsonResponse
    {            
        $users = User::orderBy('user_type')->orderBy('lastname')->get();
        return response()->json($users);
    }        

    public function getOne(Request $request, $id): JsonResponse
    {
        $user = User::find($id);
        if($user->user_type === "Student"){
            $userDetails = Student::find($id);
            $userDetails->user_status = $user->status;
            return response()->json($userDetails);
        }else if($user->user_type === "Teacher"){
            $userDetails = Teacher::find($id);
            $userDetails->user_status = $user->status;
            return response()->json($userDetails);
        }else if($user->user_type === "Non Teaching"){
            $userDetails = NonTeaching::find($id);
            $userDetails->user_status = $user->status;
            return response()->json($userDetails);
        }else if($user->user_type === "Registrar"){
            $userDetails = Registrar::find($id);
            $userDetails->user_status = $user->status;
            return response()->json($userDetails);
        }else if($user->user_type === "Dean"){
            $userDetails = Dean::find($id);
            $userDetails->user_status = $user->status;
            return response()->json($userDetails);
        }else if($user->user_type === "DeptChair"){
            $userDetails = DeptChair::find($id);
            $userDetails->user_status = $user->status;
            return response()->json($userDetails);
        }else{
            return response()->json([]);
        }        
    }

    public function getUserDetails(Request $request): JsonResponse
    {       
        $userType = auth()->user()->user_type;
        $userId = auth()->user()->id;
        if($userType === "Student"){
            $userDetails = Student::find($userId);
            return response()->json($userDetails);
        }else if($userType === "Teacher"){
            $userDetails = Teacher::find($userId);
            return response()->json($userDetails);
        }else if($userType === "Non Teaching"){
            $userDetails = NonTeaching::find($userId);
            return response()->json($userDetails);
        }else if($userType === "Registrar"){
            $userDetails = Registrar::find($userId);
            return response()->json($userDetails);
        }else if($userType === "Dean"){
            $userDetails = Dean::find($userId);
            return response()->json($userDetails);
        }else if($userType === "DeptChair"){
            $userDetails = DeptChair::find($userId);
            return response()->json($userDetails);
        }else{
            return response()->json([]);
        }
    }

    public function getProfileEditApprovals(Request $request): JsonResponse
    {                                        
        $students = Student::where('status', 'For Approval')->orderBy('lastname')->get();
        $teachers = Teacher::where('status', 'For Approval')->orderBy('lastname')->get();
        $nonTeachings = NonTeaching::where('status', 'For Approval')->orderBy('lastname')->get();
        $registrars = Registrar::where('status', 'For Approval')->orderBy('lastname')->get();
        $deans = Dean::where('status', 'For Approval')->orderBy('lastname')->get();
        $deptChairs = DeptChair::where('status', 'For Approval')->orderBy('lastname')->get();
        $users = [...$students, ...$teachers, ...$nonTeachings, ...$registrars, ...$deans, ...$deptChairs];    
        return response()->json($users);
    }

    public function getBlockchainUsers(Request $request): JsonResponse
    {                                        
        $students = Student::orderBy('lastname')->get();
        $teachers = Teacher::orderBy('lastname')->get();
        $nonTeachings = NonTeaching::orderBy('lastname')->get();
        $registrars = Registrar::orderBy('lastname')->get();
        $deans = Dean::orderBy('lastname')->get();
        $deptChairs = DeptChair::orderBy('lastname')->get();
        $users = [...$students, ...$teachers, ...$nonTeachings, ...$registrars, ...$deans, ...$deptChairs];    
        return response()->json($users);
    }

    public function verify(Request $request, $id): JsonResponse
    {                    
        User::where('id', $id)->update([
            'status'=> 'Verified',            
        ]);
        return response()->json([]);
    }

    public function reject(Request $request, $id): JsonResponse
    {                    
        User::where('id', $id)->update([
            'status'=> 'Rejected',            
        ]);
        return response()->json([]);
    }

    public function updateUserDetailsStatus(Request $request, $id, $userType): JsonResponse
    {                            
        if($userType === 'Student'){
            Student::where('id', $id)->update([
                'status'=> $request->status,            
            ]);
            return response()->json([]);
        }else if($userType === 'Teacher') {
            Teacher::where('id', $id)->update([
                'status'=> $request->status,            
            ]);
            return response()->json([]);
        }else if($userType === 'Non Teaching') {
            NonTeaching::where('id', $id)->update([
                'status'=> $request->status,            
            ]);
            return response()->json([]);
        }else if($userType === 'Registrar') {
            Registrar::where('id', $id)->update([
                'status'=> $request->status,            
            ]);
            return response()->json([]);
        }else if($userType === 'Dean') {
            Dean::where('id', $id)->update([
                'status'=> $request->status,            
            ]);
            return response()->json([]);
        }else if($userType === 'DeptChair') {
            DeptChair::where('id', $id)->update([
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
        if($userType === "Student"){
            Student::where('id', $id)->update([
                'name'=> $request->name,            
                'hash'=> Hash::make(Carbon::now()),            
                'status'=> 'uneditable',            
            ]);
            return response()->json([]);
        }else if($userType === "Teacher") {
            Teacher::where('id', $id)->update([
                'name'=> $request->name,            
                'hash'=> Hash::make(Carbon::now()),            
                'status'=> 'uneditable',            
            ]);
            return response()->json([]);
        }else if($userType === "Non Teaching") {
            NonTeaching::where('id', $id)->update([
                'name'=> $request->name,            
                'hash'=> Hash::make(Carbon::now()),            
                'status'=> 'uneditable',            
            ]);
            return response()->json([]);
        }else if($userType === "Registrar") {
            Registrar::where('id', $id)->update([
                'name'=> $request->name,            
                'hash'=> Hash::make(Carbon::now()),            
                'status'=> 'uneditable',            
            ]);
            return response()->json([]);
        }else if($userType === "Dean") {
            Dean::where('id', $id)->update([
                'name'=> $request->name,            
                'hash'=> Hash::make(Carbon::now()),            
                'status'=> 'uneditable',            
            ]);
            return response()->json([]);
        }else if($userType === "DeptChair") {
            DeptChair::where('id', $id)->update([
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
