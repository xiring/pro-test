<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::updateOrCreate([
            "email" => "teacher@yopmail.com"
        ],
        [
            "name" => 'Teacher',
            "password" => Hash::make("password"),
            'user_type' => 'teacher'
        ]);

        $role = Role::findByName('teacher', 'api');
        $user->assignRole($role);

        $student = User::updateOrCreate([
            "email" => "student@yopmail.com"
        ],
        [
            "name" => 'Student',
            "password" => Hash::make("password"),
            'user_type' => 'student'
        ]);

        $student_role = Role::findByName('student', 'api');
        $user->assignRole($student_role);
    }
}
