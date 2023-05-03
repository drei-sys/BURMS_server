<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class NonTeachingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $address = fake()->barangay() . "  " . fake()->municipality() . ", " . fake()->province();

        return [            
            'lastname' => fake()->lastname(),
            'firstname' => fake()->firstname(),
            'middlename' => '',
            'birth_date' => fake()->date(),
            'birth_place' => $address,
            'gender' => 'Male',
            'civil_status' => 'Single',
            'citizenship' => 'Filipino',
            'house_number' => fake()->buildingNumber(),
            'street' => fake()->streetName(),
            'subdivision' => '',
            'barangay' => fake()->barangay(),
            'city' => fake()->municipality(),
            'province' => fake()->province(),
            'zipcode' => fake()->randomNumber(4, true),
            'gsis' => '123',
            'pagibig' => '456',
            'philhealth' => '789',
            'sss' => '034',
            'tin' => '000-000',
            'agency_employee_no' => null,
            'elementary_school' => null,
            'elementary_remarks' => null,
            'secondary_school' => null,
            'secondary_remarks' => null,
            'vocational_school' => null,
            'vocational_remarks' => null,
            'college_school' => null,
            'college_remarks' => null,
            'graduate_studies_school' => null,
            'graduate_studies_remarks' => null,
            'work_experiences' => '[]',
            'email' => fake()->unique()->safeEmail(),            
            'user_type' => 'Non Teaching',            
            'status' => 'Uneditable',                   
        ];
    }
}
