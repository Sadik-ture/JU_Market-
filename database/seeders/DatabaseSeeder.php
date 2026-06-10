<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Clear existing data
        DB::table('users')->truncate();
        DB::table('listings')->truncate();
        DB::table('listing_photos')->truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Run seeders
        $this->call([
            AdminUserSeeder::class,
            UsersTableSeeder::class,
            ListingsTableSeeder::class,
        ]);
    }
}
