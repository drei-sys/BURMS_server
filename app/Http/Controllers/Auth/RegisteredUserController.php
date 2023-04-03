<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\NonTeaching;
use App\Models\Registrar;
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'user_type' => $request->user_type,
            'is_verified' => 0,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if($request->user_type === 3){
            Student::create([        
                'id' => $user->id,
                'name' => $request->name,
                'user_type' => $request->user_type,
                'status' => 'uneditable',                
                'hash' => Hash::make(Carbon::now()),
                'created_by' => $user->id,
                'updated_by' => $user->id,            
            ]);
        }else if($request->user_type === 4){
            Teacher::create([        
                'id' => $user->id,
                'name' => $request->name,
                'user_type' => $request->user_type,
                'status' => 'uneditable',                
                'hash' => Hash::make(Carbon::now()),
                'created_by' => $user->id,
                'updated_by' => $user->id,            
            ]);
        }else if($request->user_type === 5){
            NonTeaching::create([        
                'id' => $user->id,
                'name' => $request->name,
                'user_type' => $request->user_type,
                'status' => 'uneditable',                
                'hash' => Hash::make(Carbon::now()),
                'created_by' => $user->id,
                'updated_by' => $user->id,            
            ]);
        }else if($request->user_type === 6){
            Registrar::create([        
                'id' => $user->id,
                'name' => $request->name,
                'user_type' => $request->user_type,
                'status' => 'uneditable',                
                'hash' => Hash::make(Carbon::now()),
                'created_by' => $user->id,
                'updated_by' => $user->id,            
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
