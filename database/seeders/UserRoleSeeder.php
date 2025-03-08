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
        $user1 = User::where('email', 'masoud@g2holding.org')->first();

        if ($user1) {
            $user1->assignRole('super-admin');
        }

        $user2 = User::where('email', 'behnaz.valizadeh@g2holding.org')->first();
        if ($user2) {
            $user2->assignRole('super-admin');
        }

        $user3 = User::where('email', 'behnaz.nouri@g2holding.org')->first();
        if ($user3) {
            $user3->assignRole('super-admin');
        }

        $user4 = User::where('email', 'erfan.hemmati@g2holding.org')->first();
        if ($user4) {
            $user4->assignRole('super-admin');
        }

        $user5 = User::where('email', 'mohammad.aali@g2holding.org')->first();
        if ($user5) {
            $user5->assignRole('super-admin');
        }
    }
}
