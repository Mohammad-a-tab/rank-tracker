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
            'email'         => 'masoud@g2holding.org',
        ], [
            'name'          => 'مسعود',
            'last_name'     => 'توکلی',
            'username'      => 'masoud',
            'password'      => Hash::make('H5QDDJok'),
        ]);

        User::query()->updateOrCreate([
            'email'         => 'behnaz.valizadeh@g2holding.org',
        ], [
            'name'          => 'بهناز',
            'last_name'     => 'ولیزاده',
            'username'      => 'behnaz.valizadeh',
            'password'      => Hash::make('H5QDDJok')
        ]);

        User::query()->updateOrCreate([
            'email'         => 'behnaz.nouri@g2holding.org',
        ], [
            'name'          => 'بهناز',
            'last_name'     => 'نوری',
            'username'      => 'behnaz.nouri',
            'password'      => Hash::make('H5QDDJok')
        ]);

        User::query()->updateOrCreate([
            'email'         => 'erfan.hemmati@g2holding.org',
        ], [
            'name'          => 'عرفان',
            'last_name'     => 'همتی',
            'username'      => 'erfan.hemmati',
            'password'      => Hash::make('H5QDDJok')
        ]);

        User::query()->updateOrCreate([
            'email'         => 'mohammad.aali@g2holding.org',
        ], [
            'name'          => 'محمد',
            'last_name'     => 'عالی',
            'username'      => 'mohammad.aali',
            'password'      => Hash::make('H5QDDJok')
        ]);
    }
}
