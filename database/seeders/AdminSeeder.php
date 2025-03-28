<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleId = DB::table('role')->where('nama', 'Admin')->value('id');

        DB::table('user')->updateOrInsert(
            ['email' => 'sujiwotejo@email.com'],
            [
                'id' => Str::uuid(),
                'nama' => 'Sujiwo Tejo',
                'password' => Hash::make(env('DEFAULT_PASSWORD')),
                'role_id' => $roleId,
                'updated_at' => now(),
                'created_at' => now(),

            ]
        );
    }
}
