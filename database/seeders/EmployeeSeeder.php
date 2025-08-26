<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 1000; $i++) {
            Employee::create([
                'full_name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'join_date' => $faker->date(),
                'designation' => $faker->jobTitle,
                'gender' => $faker->randomElement(['Male', 'Female']),
                'mobile' => $faker->unique()->phoneNumber,
                'birth_date' => $faker->date('Y-m-d', '2000-01-01'),
                'address' => $faker->address,
                'image' => 'default.jpg',
                'salary' => $faker->numberBetween(20000, 80000),
                'status' => 'Active',
                'branch_name' => 'Branch '.$faker->randomElement(['A','B','C']),
                'created_by' => 'Admin',
                'nid' => $faker->unique()->numerify('###########'),
                'blood_group' => $faker->randomElement(['A+','B+','O+','AB+']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
