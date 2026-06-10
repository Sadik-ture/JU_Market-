<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Ethiopian Names - Christian & Muslim (Jimma University)
        $users = [
            // Christian Names
            ['name' => 'Abebech Demissie', 'student_id' => 'JU/1234/15', 'email' => 'abebech.d@ju.edu.et', 'department' => 'Computer Science', 'graduation_year' => 2025, 'is_verified_seller' => true],
            ['name' => 'Alemu Tadesse', 'student_id' => 'JU/1235/15', 'email' => 'alemu.t@ju.edu.et', 'department' => 'Engineering', 'graduation_year' => 2024, 'is_verified_seller' => true],
            ['name' => 'Bekele Hailemariam', 'student_id' => 'JU/1236/16', 'email' => 'bekele.h@ju.edu.et', 'department' => 'Business', 'graduation_year' => 2025],
            ['name' => 'Chaltu Fikre', 'student_id' => 'JU/1237/16', 'email' => 'chaltu.f@ju.edu.et', 'department' => 'Medicine', 'graduation_year' => 2027, 'is_verified_seller' => true],
            ['name' => 'Dawit Mekonnen', 'student_id' => 'JU/1238/17', 'email' => 'dawit.m@ju.edu.et', 'department' => 'Computer Science', 'graduation_year' => 2026],
            ['name' => 'Eden Tesfaye', 'student_id' => 'JU/1239/17', 'email' => 'eden.t@ju.edu.et', 'department' => 'Law', 'graduation_year' => 2025, 'is_verified_seller' => true],
            ['name' => 'Fikru Assefa', 'student_id' => 'JU/1240/18', 'email' => 'fikru.a@ju.edu.et', 'department' => 'Engineering', 'graduation_year' => 2026],
            ['name' => 'Genet Worku', 'student_id' => 'JU/1241/18', 'email' => 'genet.w@ju.edu.et', 'department' => 'Business', 'graduation_year' => 2024],
            ['name' => 'Habtamu Wolde', 'student_id' => 'JU/1242/19', 'email' => 'habtamu.w@ju.edu.et', 'department' => 'Computer Science', 'graduation_year' => 2025, 'is_verified_seller' => true],
            ['name' => 'Ibsa Ali', 'student_id' => 'JU/1243/19', 'email' => 'ibsa.a@ju.edu.et', 'department' => 'Engineering', 'graduation_year' => 2026],

            // Muslim Names
            ['name' => 'Khadija Mohammed', 'student_id' => 'JU/1244/20', 'email' => 'khadija.m@ju.edu.et', 'department' => 'Medicine', 'graduation_year' => 2027, 'is_verified_seller' => true],
            ['name' => 'Omar Hussein', 'student_id' => 'JU/1245/20', 'email' => 'omar.h@ju.edu.et', 'department' => 'Computer Science', 'graduation_year' => 2025],
            ['name' => 'Fatima Ahmed', 'student_id' => 'JU/1246/21', 'email' => 'fatima.a@ju.edu.et', 'department' => 'Business', 'graduation_year' => 2026, 'is_verified_seller' => true],
            ['name' => 'Yusuf Ibrahim', 'student_id' => 'JU/1247/21', 'email' => 'yusuf.i@ju.edu.et', 'department' => 'Engineering', 'graduation_year' => 2025],
            ['name' => 'Aisha Abubeker', 'student_id' => 'JU/1248/22', 'email' => 'aisha.a@ju.edu.et', 'department' => 'Law', 'graduation_year' => 2026],
            ['name' => 'Bilal Usman', 'student_id' => 'JU/1249/22', 'email' => 'bilal.u@ju.edu.et', 'department' => 'Medicine', 'graduation_year' => 2028, 'is_verified_seller' => true],
            ['name' => 'Zainab Abdella', 'student_id' => 'JU/1250/23', 'email' => 'zainab.a@ju.edu.et', 'department' => 'Computer Science', 'graduation_year' => 2025],
            ['name' => 'Hamza Nur', 'student_id' => 'JU/1251/23', 'email' => 'hamza.n@ju.edu.et', 'department' => 'Business', 'graduation_year' => 2024],
            ['name' => 'Mariam Suleiman', 'student_id' => 'JU/1252/24', 'email' => 'mariam.s@ju.edu.et', 'department' => 'Engineering', 'graduation_year' => 2026, 'is_verified_seller' => true],
            ['name' => 'Rashid Mohammed', 'student_id' => 'JU/1253/24', 'email' => 'rashid.m@ju.edu.et', 'department' => 'Computer Science', 'graduation_year' => 2025],

            // More Christian Names
            ['name' => 'Selam Tesfaye', 'student_id' => 'JU/1254/15', 'email' => 'selam.t@ju.edu.et', 'department' => 'Medicine', 'graduation_year' => 2026],
            ['name' => 'Tekle Berhan', 'student_id' => 'JU/1255/16', 'email' => 'tekle.b@ju.edu.et', 'department' => 'Engineering', 'graduation_year' => 2024, 'is_verified_seller' => true],
            ['name' => 'Tigist Belay', 'student_id' => 'JU/1256/17', 'email' => 'tigist.b@ju.edu.et', 'department' => 'Computer Science', 'graduation_year' => 2025],
            ['name' => 'Yonas Desta', 'student_id' => 'JU/1257/18', 'email' => 'yonas.d@ju.edu.et', 'department' => 'Business', 'graduation_year' => 2024],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'student_id' => $user['student_id'],
                'email' => $user['email'],
                'university_domain' => 'ju.edu.et',
                'department' => $user['department'],
                'graduation_year' => $user['graduation_year'],
                'is_verified_seller' => $user['is_verified_seller'] ?? false,
                'is_suspended' => false,
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]);
        }
    }
}
