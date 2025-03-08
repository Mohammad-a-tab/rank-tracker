<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleSuperAdmin = Role::where('name', 'super-admin')->first();

        if($roleSuperAdmin) {
            $roleSuperAdmin->givePermissionTo(
                // Dashboard
                'show dashboard',

                // User
                'import site',
                'keyword top 3',
                'get all sites',
                'month progress',
                'get title site',
                'keyword top 10',
                'import keyword',
                'request run job',
                'keyword progress',
                'get all keywords',
                'analyze-keywords',
                'get-position-flow',
                'get-losers-winners',
                'get-gainers-losers',
                'competitors-average',
                'search-volume-sites',
                'get-average-position',
                'get-top-one-competitor',
                'get-top-ten-competitor',
                'get-competitors-top-one',
                'get-competitors-top-ten',
                'get-top-three-competitor',
                'get-competitors-top-three',
                'analyze-keywords-competitor',
                'keyword-position-distribution',
                'average-history-report-competitor',
                'competitors-search-volume-ranking'
            );
        }
    }
}
