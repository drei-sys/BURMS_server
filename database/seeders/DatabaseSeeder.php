<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Dean;
use App\Models\DeptChair;
use App\Models\NonTeaching;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Section;


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
        Course::create([            
            'name' => 'BSCpE',
            'status' => 'Active',            
            'created_by' => $user->id,
            'updated_by' => $user->id,            
        ]);
        Subject::create([            
            'code' => 'FIL1',
            'name' => 'Filipino 1',
            'unit' => 3,
            'type' => 'Minor',
            'status' => 'Active',            
            'created_by' => $user->id,
            'updated_by' => $user->id,            
        ]);
        Subject::create([            
            'code' => 'ENG1',
            'name' => 'English 1',
            'unit' => 3,
            'type' => 'Minor',
            'status' => 'Active',            
            'created_by' => $user->id,
            'updated_by' => $user->id,            
        ]);
        Subject::create([            
            'code' => 'CS101',
            'name' => 'Computer Programming 1',
            'unit' => 4,
            'type' => 'Major',
            'status' => 'Active',            
            'created_by' => $user->id,
            'updated_by' => $user->id,            
        ]);
        Subject::create([            
            'code' => 'CpE101',
            'name' => 'CpE Major Subject',
            'unit' => 4,
            'type' => 'Major',
            'status' => 'Active',            
            'created_by' => $user->id,
            'updated_by' => $user->id,            
        ]);
        Subject::create([            
            'code' => 'ENG2',
            'name' => 'English 2',
            'unit' => 3,
            'type' => 'Minor',
            'status' => 'Active',            
            'created_by' => $user->id,
            'updated_by' => $user->id,            
        ]);
        Section::create([            
            'name' => '1IT-1',
            'status' => 'Active',            
            'created_by' => $user->id,
            'updated_by' => $user->id,            
        ]);
        Section::create([            
            'name' => '1IT-2',
            'status' => 'Active',            
            'created_by' => $user->id,
            'updated_by' => $user->id,            
        ]);
        Section::create([            
            'name' => '1CpE-1',
            'status' => 'Active',            
            'created_by' => $user->id,
            'updated_by' => $user->id,            
        ]);

        //student 1
        $student = User::factory()->create([
            'user_type' => 'Student',
            'status' => 'Verified',
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
            'status' => 'Verified',
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
        //student 3
        $student = User::factory()->create([
            'extname' => '',
            'user_type' => 'Student',
            'status' => 'Verified',
        ]);
        Student::factory()->create([           
            'id' => $student->id,
            'lastname' => $student->lastname,
            'firstname' => $student->firstname,
            'middlename' => $student->middlename,
            'extname' => $student->extname,
            'email' => $student->email,
            'course_id' => 2,
            'user_type' => $student->user_type,                        
            'created_by' => $student->id,
            'updated_by' => $student->id,
        ]);
        //student 4
        $student = User::factory()->create([
            'extname' => '',
            'user_type' => 'Student',
            'status' => 'Verified',
        ]);
        Student::factory()->create([           
            'id' => $student->id,
            'lastname' => $student->lastname,
            'firstname' => $student->firstname,
            'middlename' => $student->middlename,
            'extname' => $student->extname,
            'email' => $student->email,
            'course_id' => 2,
            'user_type' => $student->user_type,                        
            'created_by' => $student->id,
            'updated_by' => $student->id,
        ]);

        //--------------------------------------------------------

        //teacher 1
        $teacher = User::factory()->create([
            'user_type' => 'Teacher',
            'status' => 'Verified',
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
            'status' => 'Verified',
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
            'status' => 'Verified',
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
            'status' => 'Verified',
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

        //----------------------------------------------------------
        //deptchair 1
        $nonTeaching = User::factory()->create([
            'user_type' => 'Non Teaching',
            'status' => 'Verified',
        ]);
        NonTeaching::factory()->create([           
            'id' => $nonTeaching->id,
            'lastname' => $nonTeaching->lastname,
            'firstname' => $nonTeaching->firstname,
            'middlename' => $nonTeaching->middlename,
            'extname' => $nonTeaching->extname,
            'email' => $nonTeaching->email,            
            'user_type' => $nonTeaching->user_type,                        
            'created_by' => $nonTeaching->id,
            'updated_by' => $nonTeaching->id,
        ]);
    }

}
