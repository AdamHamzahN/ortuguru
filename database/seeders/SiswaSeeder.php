<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Jurusan
        // Pastikan jurusan sudah ada, jika tidak, buat baru
        $jurusanId = DB::table('jurusan')->where('nama_jurusan', 'Rekayasa Perangkat Lunak')->value('id');
        $kaprogId = DB::table('guru')->where('user_id',DB::table('user')->where('nama','Dela Chaerani, M.Kom.')->value('id'))->value('id');

        if (!$jurusanId) {
            $jurusanId = Str::uuid();
            DB::table('jurusan')->insert([
                'id' => $jurusanId,
                'nama_jurusan' => 'Rekayasa Perangkat Lunak',
                'kepala_program_id'=> $kaprogId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Pastikan angkatan sudah ada, jika tidak, buat baru
        $angkatanId = DB::table('angkatan')->where('tahun_masuk', '2022')->value('id');

        if (!$angkatanId) {
            $angkatanId = Str::uuid();
            DB::table('angkatan')->insert([
                'id' => $angkatanId,
                'tahun_masuk' => '2022',
                'tahun_keluar' => '2025',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        //kelas
        $userGuruId = DB::table('user')->where('nama', '=', 'Dela Chaerani, M.Kom.')->value('id');
        $guruId = DB::table('guru')->where('user_id', '=', $userGuruId)->value('id');
        $kelasId = DB::table('kelas')->where([
            ['nama_kelas', '=', 'RPL A'],
            ['angkatan_id', '=', $angkatanId],
            ['jurusan_id', '=', $jurusanId]
        ])->value('id');

        if (!$kelasId) {
            $kelasId = Str::uuid();

            DB::table('kelas')->insert([
                'id' => $kelasId,
                'guru_id' => $guruId,
                'jurusan_id' => $jurusanId,
                'angkatan_id' => $angkatanId,
                'nama_kelas' => 'RPL A',
                'status' => 'belum lulus',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Orang tua siswa
        $roleId = DB::table('role')->where('nama', 'Orang Tua Siswa')->value('id');

        // Cari user dengan email atau buat baru
        $userSiswaId = DB::table('user')->where('email', 'farrelsaverosuta@email.com')->value('id');

        if (!$userSiswaId) {
            $userSiswaId = Str::uuid();
            DB::table('user')->insert([
                'id' => $userSiswaId,
                'nama' => 'Farrel Savero Suta',
                'email' => 'farrelsaverosuta@email.com',
                'password' => Hash::make(env('DEFAULT_PASSWORD', 'defaultpassword')),
                'role_id' => $roleId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Cari orang tua siswa atau buat baru
        // Cari atau buat orang tua siswa
        $orangTuaId = DB::table('orang_tua_siswa')->where('user_id', $userSiswaId)->value('id');

        if (!$orangTuaId) {
            $orangTuaId = Str::uuid();
            DB::table('orang_tua_siswa')->insert([
                'id' => $orangTuaId,
                'user_id' => $userSiswaId,
                'ayah' => 'Budi Santoso',
                'ibu' => 'Siti Aminah',
                'no_telepon_ortu' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            // Update data jika sudah ada
            DB::table('orang_tua_siswa')->where('id', $orangTuaId)->update([
                'ayah' => 'Budi Santoso',
                'ibu' => 'Siti Aminah',
                'no_telepon_ortu' => '081234567890',
                'updated_at' => now(),
            ]);
        }


        DB::table('siswa')->updateOrInsert(
            ['nis' => '1234567890'], // Jika NIS ini sudah ada, maka update
            [
                'id' => DB::table('siswa')->where('nis', '1234567890')->value('id') ?? Str::uuid(),
                'kelas_id' => $kelasId,
                'orang_tua_id' => $orangTuaId,
                'nis' => '1234567890',
                'nisn' => '9876543210',
                'jenis_kelamin' => 'laki-laki',
                'tempat_lahir' => 'Bekasi',
                'tanggal_lahir' => '2006-08-15',
                'alamat' => 'Jl. Pendidikan No. 10, Bekasi',
                'foto' => 'example/siswa/siswa1.jpg',
                'ijazah_smp' => 'example/ijazah/ijazah1.pdf',
                'akte_kelahiran' => 'example/akte_kelahiran/akte1.pdf',
                'kartu_keluarga' => 'example/kartu_keluarga/kartu_keluarga1.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
