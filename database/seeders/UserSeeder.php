<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->updateOrCreate([
            'email'         => 'test@gmail.com',
        ], [
            'name'          => 'test',
            'last_name'     => 'test',
            'username'      => 'test',
            'password'      => Hash::make('123456'),
        ]);
    }
}
