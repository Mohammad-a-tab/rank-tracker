<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

//         User::factory(1)->create();
//         UserDetail::factory(1)->create();
//         UserEducation::factory(10)->create();
//         UserLanguage::factory(10)->create();
//         UserFinancialInformation::factory(10)->create();


        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            RolePermissionSeeder::class,
            UserRoleSeeder::class,
//            KeywordSeeder::class,
        ]);
    }
}
