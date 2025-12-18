<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Administrator;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Administrator::create([
            'username' => 'adnandewa',
            'email' => 'adnandewa@gmail.com',
            'password_hash' => Hash::make('Adnan013245*'),
            'full_name' => 'Super Admin',
            'role' => 'superadmin',
            'status' => 'active',
        ]);
    }
}
