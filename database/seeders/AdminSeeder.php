<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'managerCPM',
            'username' => 'manager-cpm',
            'email' => 'managercpm@gmail.com',
            'password' => bcrypt('berbinar123'),
        ])->assignRole('manager-cpm');

        User::create([
            'name' => 'SecretaryFinance',
            'username' => 'secfin',
            'email' => 'secfin@gmail.com',
            'password' => bcrypt('berbinar123'),
        ])->assignRole('secfin');
    }
}
