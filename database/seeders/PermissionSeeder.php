<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Keyword permission
        Permission::query()
            ->updateOrCreate(['name' => 'manage-keywords']);

        // Sites permission
        Permission::query()
            ->updateOrCreate(['name' => 'manage-sites']);

        // Site details permission
        Permission::query()
            ->updateOrCreate(['name' => 'manage-site-details']);
    }
}
