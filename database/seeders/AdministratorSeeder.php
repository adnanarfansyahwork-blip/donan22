<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('administrators')->insert([
            [
                'id' => 1,
                'username' => 'admin',
                'full_name' => 'Administrator',
                'email' => 'admin@donan22.com',
                'password_hash' => Hash::make('admin123'), // Change this password!
                'role' => 'admin',
                'avatar' => 'administrators/admin-avatar.png',
                'status' => 'active',
                'created_at' => '2025-09-27 17:28:19',
                'updated_at' => '2025-10-04 22:33:02',
            ],
            [
                'id' => 2,
                'username' => 'superdonan22',
                'full_name' => 'Superdonan22',
                'email' => 'superdonan22@donan22.com',
                'password_hash' => Hash::make('admin123'), // Change this password!
                'role' => 'super_admin',
                'avatar' => 'administrators/superdonan22-avatar.png',
                'status' => 'active',
                'created_at' => '2025-10-04 19:20:05',
                'updated_at' => '2025-10-04 19:20:05',
            ],
            [
                'id' => 3,
                'username' => 'adnandewa',
                'full_name' => 'Adnan Dewa',
                'email' => 'adnandewa@donan22.com',
                'password_hash' => Hash::make('admin123'), // Change this password!
                'role' => 'admin',
                'avatar' => 'administrators/adnandewa-avatar.png',
                'status' => 'active',
                'created_at' => '2025-10-04 20:47:10',
                'updated_at' => '2025-10-04 20:47:10',
            ],
            [
                'id' => 4,
                'username' => 'editor',
                'full_name' => 'Editor',
                'email' => 'editor@donan22.com',
                'password_hash' => Hash::make('editor123'), // Change this password!
                'role' => 'editor',
                'avatar' => null,
                'status' => 'active',
                'created_at' => '2025-09-27 17:28:19',
                'updated_at' => '2025-09-27 17:28:19',
            ],
            [
                'id' => 5,
                'username' => 'moderator',
                'full_name' => 'Moderator',
                'email' => 'moderator@donan22.com',
                'password_hash' => Hash::make('moderator123'), // Change this password!
                'role' => 'moderator',
                'avatar' => null,
                'status' => 'active',
                'created_at' => '2025-09-27 17:28:19',
                'updated_at' => '2025-09-27 17:28:19',
            ],
        ]);
    }
}
