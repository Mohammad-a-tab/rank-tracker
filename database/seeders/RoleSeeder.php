<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create super admin role
        Role::query()->updateOrCreate([
           'name' => 'super-admin',
        ], [
            'name_fa' => 'ادمین کل'
        ]);

        // create user role
        Role::query()->updateOrCreate([
            'name' => 'user',
        ], [
            'name_fa' => 'کاربر'
        ]);
    }
}
