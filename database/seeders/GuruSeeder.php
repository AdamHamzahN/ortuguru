<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuruSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // Ambil ID Role Guru
        $roleId = DB::table('role')->where('nama', 'Guru')->value('id');

        // Cek apakah user sudah ada, jika tidak buat baru
        $userId = DB::table('user')->where('email', 'delachaerani@email.com')->value('id');

        if (!$userId) {
            $userId = Str::uuid();
            DB::table('user')->insert([
                'id' => $userId,
                'nama' => 'Dela Chaerani, M.Kom.',
                'email' => 'delachaerani@email.com',
                'password' => Hash::make(env('DEFAULT_PASSWORD', 'defaultpassword')),
                'role_id' => $roleId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Cek apakah Guru sudah ada, jika tidak buat baru
        $guruId = DB::table('guru')->where('user_id', $userId)->value('id');

        if (!$guruId) {
            $guruId = Str::uuid();
            DB::table('guru')->insert([
                'id' => $guruId,
                'user_id' => $userId,
                'jenis_kelamin' => 'Perempuan',
                'alamat' => 'Jl. Merdeka No. 10, Bekasi',
                'tanggal_lahir' => '1985-05-15',
                'tempat_lahir' => 'Jakarta',
                'foto' => 'example/guru/guru1.jpg',
                'nip' => '198505152022011001',
                'nomor_telepon' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Cek apakah Mata Pelajaran sudah ada, jika tidak buat baru
        $mataPelajaranId = DB::table('mata_pelajaran')
            ->where('nama_pelajaran', 'Program Keahlian Rekayasa Perangkat Lunak')
            ->value('id');

        if (!$mataPelajaranId) {
            $mataPelajaranId = Str::uuid();
            DB::table('mata_pelajaran')->insert([
                'id' => $mataPelajaranId,
                'nama_pelajaran' => 'Program Keahlian Rekayasa Perangkat Lunak',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Cek apakah guru sudah mengajar mata pelajaran tersebut, jika tidak, tambahkan
        $mengajarId = DB::table('mengajar')->where([
            ['guru_id', '=', $guruId],
            ['mata_pelajaran_id', '=', $mataPelajaranId]
        ])->value('id');

        if (!$mengajarId) {
            $mengajarId = Str::uuid();
            DB::table('mengajar')->insert([
                'id' => $mengajarId,
                'guru_id' => $guruId,
                'mata_pelajaran_id' => $mataPelajaranId,
            ]);
        }
    }
}
