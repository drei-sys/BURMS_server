<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\NonTeaching;
use App\Models\Registrar;
use App\Models\Dean;
use App\Models\DeptChair;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([            
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'user_type' => $request->user_type,
            'is_verified' => 0,
            'name' => $request->firstname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        if($request->user_type === 3){
            Student::create([
                'id' => $user->id,                
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'extname' => $request->extname,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'address' => $request->address,
                'civil_status' => $request->civil_status,
                'contact' => $request->contact,
                'is_cabuyeno' => $request->is_cabuyeno,
                'is_registered_voter' => $request->is_registered_voter,
                'is_fully_vaccinated' => $request->is_fully_vaccinated,
                'father_name' => $request->father_name,
                'father_occupation' => $request->father_occupation,
                'father_contact' => $request->father_contact,
                'is_father_voter_of_cabuyao' => $request->is_father_voter_of_cabuyao,
                'mother_name' => $request->mother_name,
                'mother_occupation' => $request->mother_occupation,
                'mother_contact' => $request->mother_contact,
                'is_mother_voter_of_cabuyao' => $request->is_mother_voter_of_cabuyao,
                'is_living_with_parents' => $request->is_living_with_parents,
                'education_attained' => $request->education_attained,
                'last_school_attended' => $request->last_school_attended,
                'school_address' => $request->school_address,
                'award_received' => $request->award_received,
                'sh_school_strand' => $request->sh_school_strand,
                'email' => $request->email,
                'course_id' => $request->course_id,
                'user_type' => $request->user_type,
                'hash' => Hash::make(Carbon::now()),
                'status' => 'uneditable',                
                'created_by' => $user->id,
                'updated_by' => $user->id,            
            ]);
        }else if($request->user_type === 4){
            Teacher::create([
                'id' => $user->id,               
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'birth_date' => $request->birth_date,
                'birth_place' => $request->birth_place,
                'gender' => $request->gender,
                'civil_status' => $request->civil_status,
                'citizenship' => $request->citizenship,
                'house_number' => $request->house_number,
                'street' => $request->street,
                'subdivision' => $request->subdivision,
                'barangay' => $request->barangay,
                'city' => $request->city,
                'province' => $request->province,
                'zipcode' => $request->zipcode,
                'gsis' => $request->gsis,
                'pagibig' => $request->pagibig,
                'philhealth' => $request->philhealth,
                'sss' => $request->sss,
                'tin' => $request->tin,
                'agency_employee_no' => $request->agency_employee_no,
                'elementary_school' => $request->elementary_school,
                'elementary_remarks' => $request->elementary_remarks,
                'secondary_school' => $request->secondary_school,
                'secondary_remarks' => $request->secondary_remarks,
                'vocational_school' => $request->vocational_school,
                'vocational_remarks' => $request->vocational_remarks,
                'college_school' => $request->college_school,
                'college_remarks' => $request->college_remarks,
                'graduate_studies_school' => $request->graduate_studies_school,
                'graduate_studies_remarks' => $request->graduate_studies_remarks,
                'work_experiences' => $request->work_experiences,
                'email' => $request->email,
                'user_type' => $request->user_type,
                'hash' => Hash::make(Carbon::now()),
                'status' => 'uneditable',                
                'created_by' => $user->id,
                'updated_by' => $user->id,       
            ]);
        }else if($request->user_type === 5){
            NonTeaching::create([
                'id' => $user->id,               
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'birth_date' => $request->birth_date,
                'birth_place' => $request->birth_place,
                'gender' => $request->gender,
                'civil_status' => $request->civil_status,
                'citizenship' => $request->citizenship,
                'house_number' => $request->house_number,
                'street' => $request->street,
                'subdivision' => $request->subdivision,
                'barangay' => $request->barangay,
                'city' => $request->city,
                'province' => $request->province,
                'zipcode' => $request->zipcode,
                'gsis' => $request->gsis,
                'pagibig' => $request->pagibig,
                'philhealth' => $request->philhealth,
                'sss' => $request->sss,
                'tin' => $request->tin,
                'agency_employee_no' => $request->agency_employee_no,
                'elementary_school' => $request->elementary_school,
                'elementary_remarks' => $request->elementary_remarks,
                'secondary_school' => $request->secondary_school,
                'secondary_remarks' => $request->secondary_remarks,
                'vocational_school' => $request->vocational_school,
                'vocational_remarks' => $request->vocational_remarks,
                'college_school' => $request->college_school,
                'college_remarks' => $request->college_remarks,
                'graduate_studies_school' => $request->graduate_studies_school,
                'graduate_studies_remarks' => $request->graduate_studies_remarks,
                'work_experiences' => $request->work_experiences,
                'email' => $request->email,
                'user_type' => $request->user_type,
                'hash' => Hash::make(Carbon::now()),
                'status' => 'uneditable',                
                'created_by' => $user->id,
                'updated_by' => $user->id,       
            ]);
        }else if($request->user_type === 6){
            Registrar::create([
                'id' => $user->id,               
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'birth_date' => $request->birth_date,
                'birth_place' => $request->birth_place,
                'gender' => $request->gender,
                'civil_status' => $request->civil_status,
                'citizenship' => $request->citizenship,
                'house_number' => $request->house_number,
                'street' => $request->street,
                'subdivision' => $request->subdivision,
                'barangay' => $request->barangay,
                'city' => $request->city,
                'province' => $request->province,
                'zipcode' => $request->zipcode,
                'gsis' => $request->gsis,
                'pagibig' => $request->pagibig,
                'philhealth' => $request->philhealth,
                'sss' => $request->sss,
                'tin' => $request->tin,
                'agency_employee_no' => $request->agency_employee_no,
                'elementary_school' => $request->elementary_school,
                'elementary_remarks' => $request->elementary_remarks,
                'secondary_school' => $request->secondary_school,
                'secondary_remarks' => $request->secondary_remarks,
                'vocational_school' => $request->vocational_school,
                'vocational_remarks' => $request->vocational_remarks,
                'college_school' => $request->college_school,
                'college_remarks' => $request->college_remarks,
                'graduate_studies_school' => $request->graduate_studies_school,
                'graduate_studies_remarks' => $request->graduate_studies_remarks,
                'work_experiences' => $request->work_experiences,
                'email' => $request->email,
                'user_type' => $request->user_type,
                'hash' => Hash::make(Carbon::now()),
                'status' => 'uneditable',                
                'created_by' => $user->id,
                'updated_by' => $user->id,       
            ]);
        }else if($request->user_type === 7){
            Dean::create([
                'id' => $user->id,               
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'birth_date' => $request->birth_date,
                'birth_place' => $request->birth_place,
                'gender' => $request->gender,
                'civil_status' => $request->civil_status,
                'citizenship' => $request->citizenship,
                'house_number' => $request->house_number,
                'street' => $request->street,
                'subdivision' => $request->subdivision,
                'barangay' => $request->barangay,
                'city' => $request->city,
                'province' => $request->province,
                'zipcode' => $request->zipcode,
                'gsis' => $request->gsis,
                'pagibig' => $request->pagibig,
                'philhealth' => $request->philhealth,
                'sss' => $request->sss,
                'tin' => $request->tin,
                'agency_employee_no' => $request->agency_employee_no,
                'elementary_school' => $request->elementary_school,
                'elementary_remarks' => $request->elementary_remarks,
                'secondary_school' => $request->secondary_school,
                'secondary_remarks' => $request->secondary_remarks,
                'vocational_school' => $request->vocational_school,
                'vocational_remarks' => $request->vocational_remarks,
                'college_school' => $request->college_school,
                'college_remarks' => $request->college_remarks,
                'graduate_studies_school' => $request->graduate_studies_school,
                'graduate_studies_remarks' => $request->graduate_studies_remarks,
                'work_experiences' => $request->work_experiences,
                'email' => $request->email,
                'user_type' => $request->user_type,
                'hash' => Hash::make(Carbon::now()),
                'status' => 'uneditable',                
                'created_by' => $user->id,
                'updated_by' => $user->id,       
            ]);
        }else if($request->user_type === 8){
            DeptChair::create([
                'id' => $user->id,               
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'birth_date' => $request->birth_date,
                'birth_place' => $request->birth_place,
                'gender' => $request->gender,
                'civil_status' => $request->civil_status,
                'citizenship' => $request->citizenship,
                'house_number' => $request->house_number,
                'street' => $request->street,
                'subdivision' => $request->subdivision,
                'barangay' => $request->barangay,
                'city' => $request->city,
                'province' => $request->province,
                'zipcode' => $request->zipcode,
                'gsis' => $request->gsis,
                'pagibig' => $request->pagibig,
                'philhealth' => $request->philhealth,
                'sss' => $request->sss,
                'tin' => $request->tin,
                'agency_employee_no' => $request->agency_employee_no,
                'elementary_school' => $request->elementary_school,
                'elementary_remarks' => $request->elementary_remarks,
                'secondary_school' => $request->secondary_school,
                'secondary_remarks' => $request->secondary_remarks,
                'vocational_school' => $request->vocational_school,
                'vocational_remarks' => $request->vocational_remarks,
                'college_school' => $request->college_school,
                'college_remarks' => $request->college_remarks,
                'graduate_studies_school' => $request->graduate_studies_school,
                'graduate_studies_remarks' => $request->graduate_studies_remarks,
                'work_experiences' => $request->work_experiences,
                'email' => $request->email,
                'user_type' => $request->user_type,
                'hash' => Hash::make(Carbon::now()),
                'status' => 'uneditable',                
                'created_by' => $user->id,
                'updated_by' => $user->id,       
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
