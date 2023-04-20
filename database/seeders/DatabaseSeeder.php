<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Dean;
use App\Models\DeptChair;
use App\Models\Course;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {        
        

        $user = User::factory()->create([
            'lastname' => 'Admin',
            'firstname' => 'Christian Andrei',
            'middlename' => 'Z',
            'email' => 'christianandreizpapa@gmail.com',
            'user_type' => 'Admin',
            'status' => 'Admin',
        ]); 

        Course::create([            
            'name' => 'BSIT',
            'status' => 'Active',            
            'created_by' => $user->id,
            'updated_by' => $user->id,            
        ]);

        //student 1
        $student = User::factory()->create([
            'user_type' => 'Student',
            'status' => 'For Verification',
        ]);
        Student::factory()->create([           
            'id' => $student->id,
            'lastname' => $student->lastname,
            'firstname' => $student->firstname,
            'middlename' => $student->middlename,
            'extname' => $student->extname,
            'email' => $student->email,
            'course_id' => 1,
            'user_type' => $student->user_type,                        
            'created_by' => $student->id,
            'updated_by' => $student->id,
        ]);
        //student 2
        $student = User::factory()->create([
            'extname' => 'JR.',
            'user_type' => 'Student',
            'status' => 'For Verification',
        ]);
        Student::factory()->create([           
            'id' => $student->id,
            'lastname' => $student->lastname,
            'firstname' => $student->firstname,
            'middlename' => $student->middlename,
            'extname' => $student->extname,
            'email' => $student->email,
            'course_id' => 1,
            'user_type' => $student->user_type,                        
            'created_by' => $student->id,
            'updated_by' => $student->id,
        ]);

        //--------------------------------------------------------

        //teacher 1
        $teacher = User::factory()->create([
            'user_type' => 'Teacher',
            'status' => 'For Verification',
        ]);
        Teacher::factory()->create([
            'id' => $teacher->id,
            'lastname' => $teacher->lastname,
            'firstname' => $teacher->firstname,
            'middlename' => $teacher->middlename,
            'extname' => $teacher->extname,
            'email' => $teacher->email,
            'user_type' => $teacher->user_type,
            'created_by' => $teacher->id,
            'updated_by' => $teacher->id,
        ]);
        //teacher 2
        $teacher = User::factory()->create([
            'user_type' => 'Teacher',
            'status' => 'For Verification',
        ]);
        Teacher::factory()->create([           
            'id' => $teacher->id,
            'lastname' => $teacher->lastname,
            'firstname' => $teacher->firstname,
            'middlename' => $teacher->middlename,
            'extname' => $teacher->extname,
            'email' => $teacher->email,            
            'user_type' => $teacher->user_type,                        
            'created_by' => $teacher->id,
            'updated_by' => $teacher->id,
        ]);

        //--------------------------------------------------------

        //dean 1
        $dean = User::factory()->create([
            'user_type' => 'Dean',
            'status' => 'For Verification',
        ]);
        Dean::factory()->create([           
            'id' => $dean->id,
            'lastname' => $dean->lastname,
            'firstname' => $dean->firstname,
            'middlename' => $dean->middlename,
            'extname' => $dean->extname,
            'email' => $dean->email,            
            'user_type' => $dean->user_type,                        
            'created_by' => $dean->id,
            'updated_by' => $dean->id,
        ]);

        //--------------------------------------------------------

        //deptchair 1
        $deptchair = User::factory()->create([
            'user_type' => 'DeptChair',
            'status' => 'For Verification',
        ]);
        DeptChair::factory()->create([           
            'id' => $deptchair->id,
            'lastname' => $deptchair->lastname,
            'firstname' => $deptchair->firstname,
            'middlename' => $deptchair->middlename,
            'extname' => $deptchair->extname,
            'email' => $deptchair->email,            
            'user_type' => $deptchair->user_type,                        
            'created_by' => $deptchair->id,
            'updated_by' => $deptchair->id,
        ]);
    }

}
