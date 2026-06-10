<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'student_id' => 'RU1770/15',
            'email' => 'admin@ju.edu.et',
            'university_domain' => 'ju.edu.et',
            'department' => 'Software Engineering',
            'graduation_year' => 2027,
            'is_verified_seller' => true,
            'is_admin' => true,
            'is_suspended' => false,
            'password' => Hash::make('12341234'),
            'email_verified_at' => now(),
        ]);
    }
}
