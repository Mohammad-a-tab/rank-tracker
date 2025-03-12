<?php

namespace Database\Seeders;

use Exception;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws Exception
     */
    public function run(): void
    {
        $user = User::query()->where('email', 'test@gmail.com')->first();

        $user?->assignRole('super-admin');
    }
}
