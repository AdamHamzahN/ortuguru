<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleId = DB::table('role')->where('nama', 'Super Admin')->value('id');

        DB::table('user')->updateOrInsert(
            ['email' => 'adminsmkn1bekasi@email.com'],
            [
                'id' => Str::uuid(),
                'nama' => 'Admin SMKN 1 Bekasi',
                'password' => Hash::make('adminsmkn1bekasi'),
                'role_id' => $roleId,
                'updated_at' => now(),
                'created_at' => now(),

            ]
        );
    }
}
