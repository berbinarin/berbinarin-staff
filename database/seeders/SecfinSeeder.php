<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class SecfinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'SecretaryFinance',
            'username' => 'secfin',
            'email' => 'secfin@gmail.com',
            'password' => bcrypt('berbinar123'),
        ])->assignRole('secfin');
    }
}
