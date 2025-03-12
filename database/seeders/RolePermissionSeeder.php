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
        $roleSuperAdmin = Role::query()->where('name', 'super-admin')->first();

        $roleSuperAdmin?->givePermissionTo(
            "manage-keywords",

            "manage-sites",

            "manage-site-details"
        );
    }
}
