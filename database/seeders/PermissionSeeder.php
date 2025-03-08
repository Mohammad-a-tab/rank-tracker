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

        // Dashboard permissions
        Permission::query()
            ->updateOrCreate(['name' => 'show dashboard']);

        // User permissions
        Permission::query()
            ->updateOrCreate(['name' => 'month progress']);

        Permission::query()
            ->updateOrCreate(['name' => 'keyword top 3']);

        Permission::query()
            ->updateOrCreate(['name' => 'keyword top 10']);

        Permission::query()
            ->updateOrCreate(['name' => 'keyword progress']);

        Permission::query()
            ->updateOrCreate(['name' => 'import keyword']);

        Permission::query()
            ->updateOrCreate(['name' => 'import site']);

        Permission::query()
            ->updateOrCreate(['name' => 'request run job']);

        Permission::query()
            ->updateOrCreate(['name' => 'get all sites']);

        Permission::query()
            ->updateOrCreate(['name' => 'get all keywords']);

        Permission::query()
            ->updateOrCreate(['name' => 'get title site']);

        Permission::query()
            ->updateOrCreate(['name' => 'get-average-position']);

        Permission::query()
            ->updateOrCreate(['name' => 'search-volume-sites']);

        Permission::query()
            ->updateOrCreate(['name' => 'get-competitors-top-one']);

        Permission::query()
            ->updateOrCreate(['name' => 'get-competitors-top-three']);

        Permission::query()
            ->updateOrCreate(['name' => 'get-competitors-top-ten']);

        Permission::query()
            ->updateOrCreate(['name' => 'competitors-average']);

        Permission::query()
            ->updateOrCreate(['name' => 'analyze-keywords']);

        Permission::query()
            ->updateOrCreate(['name' => 'keyword-position-distribution']);

        Permission::query()
            ->updateOrCreate(['name' => 'average-history-report-competitor']);

        Permission::query()
            ->updateOrCreate(['name' => 'get-top-one-competitor']);

        Permission::query()
            ->updateOrCreate(['name' => 'get-top-three-competitor']);

        Permission::query()
            ->updateOrCreate(['name' => 'get-top-ten-competitor']);

        Permission::query()
            ->updateOrCreate(['name' => 'analyze-keywords-competitor']);

        Permission::query()
            ->updateOrCreate(['name' => 'get-losers-winners']);

        Permission::query()
            ->updateOrCreate(['name' => 'get-gainers-losers']);

        Permission::query()
            ->updateOrCreate(['name' => 'get-position-flow']);

        Permission::query()
            ->updateOrCreate(['name' => 'competitors-search-volume-ranking']);
    }
}
