<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mengajar;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class GuruController extends Controller
{
    public function adminDaftarGuru()
    {
        return view('admin.guru.index');
    }
    public function tambahGuru()
    {
        return view('admin.guru.tambah');
    }

    public function detailGuru($id)
    {
        $guru = DB::table('guru')
            ->join('user', 'user.id', '=', 'guru.user_id')
            ->where('guru.id', $id)
            ->select('guru.*', 'user.nama', 'user.email', 'user.status')
            ->first();

        $mataPelajaran = DB::table('mengajar')
            ->join('mata_pelajaran', 'mata_pelajaran.id', '=', 'mengajar.mata_pelajaran_id')
            ->where('mengajar.guru_id', $id)
            ->select('mata_pelajaran.nama_pelajaran')
            ->get();

        $waliKelas = DB::table('kelas')
            ->join('guru', 'guru.id', '=', 'kelas.guru_id')
            ->where('kelas.guru_id', $id)
            ->where('kelas.status', '!=', 'lulus')
            ->select('kelas.nama_kelas as nama_kelas')
            ->first();

        $data = [
            'guru' => $guru,
            'mataPelajaran' => $mataPelajaran,
            'waliKelas' => $waliKelas
        ];

        return view('admin.guru.detail', $data);
    }


    public function dataGuru()
    {
        $gururole = Role::where('nama', 'Guru')->value('id');

        if (!$gururole) {
            return response()->json(['error' => 'Role Guru tidak ditemukan!'], 400);
        }

        $data = User::where('role_id', $gururole)
            ->leftJoin('guru', 'guru.user_id', '=', 'user.id')
            ->select('user.id', 'user.nama', 'user.status', 'guru.id', 'guru.nip');

        return DataTables::of($data)
            ->editColumn('created_at', function ($user) {
                return $user->created_at ? $user->created_at->format('d-m-Y') : 'N/A';
            })
            ->make(true);
    }

    public function listGuru(Request $request)
    {
        $gururole = Role::where('nama', 'Guru')->value('id');

        if (!$gururole) {
            return response()->json(['error' => 'Role Guru tidak ditemukan!'], 400);
        }

        $search = $request->input('q');

        $query = User::where('role_id', $gururole)
            ->leftJoin('guru', 'guru.user_id', '=', 'user.id')
            ->select('guru.id', 'user.nama', 'guru.nip');

        if ($search) {
            $query->where('user.nama', 'like', '%' . $search . '%');
        }

        $data = $query->limit(5)->get();

        $formatted = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->nama . ' - ' . ($item->nip ?? 'NIP tidak tersedia'),
            ];
        });

        return response()->json(['results' => $formatted]);
    }

    public function simpan(Request $request)
    {
        $data = $request->validate([
            'nip' => ['required'],
            'nama' => ['required'],
            'jenis_kelamin' => ['required'],
            'agama' => ['required'],
            'tempat_lahir' => ['required'],
            'tanggal_lahir' => ['required'],
            'email' => ['required', 'email'],
            'nomor_telepon' => ['required'],
            'alamat' => ['required'],
            'mata_pelajaran' => ['required'],
            'foto' => ['required']
        ]);

        $nipexists = Guru::where('nip', '=', $request['nip'])->exists();
        $emailexists = User::where('email', '=', $request['email'])->exists();

        if ($nipexists) {
            return response()->json([
                'status' => 'failed',
                'pesan' => 'NIP sudah ada'
            ], 200);
        }

        if ($emailexists) {
            return response()->json([
                'status' => 'failed',
                'pesan' => 'Email sudah ada'
            ], 200);
        }

        if (!$emailexists) {
            $data['password'] = Hash::make(env('DEFAULT_PASSWORD'));
            $data['role_id'] =  Role::where('nama', 'Guru')->value('id');

            $user = [
                'email' => $data['email'],
                'password' => $data['password'],
                'role_id' => $data['role_id'],
                'nama' => $data['nama']
            ];
            $createduser = User::create($user);

            if ($createduser) {
                $foto = $request->file('foto');
                $filename = Str::uuid() . '.' . $foto->getClientOriginalExtension(); // acak nama file
                $path = $foto->storeAs('foto_guru', $filename, 'public');
                $guru = [
                    'nip' => $data['nip'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'agama' => $data['agama'],
                    'tempat_lahir' => $data['tempat_lahir'],
                    'tanggal_lahir' => $data['tanggal_lahir'],
                    'nomor_telepon' => $data['nomor_telepon'],
                    'alamat' => $data['alamat'],
                    'foto' => $path,
                    'user_id' => $createduser->id
                ];

                $createdguru = Guru::create($guru);

                if ($createdguru) {
                    $matapelajaran = $data['mata_pelajaran'];

                    foreach ($matapelajaran as $mapel) {
                        $mengajar = [
                            'mata_pelajaran_id' => $mapel,
                            'guru_id' => $createdguru->id
                        ];
                        Mengajar::create($mengajar);
                    }
                    return response()->json([
                        'status' => 'success',
                        'pesan' => 'Berhasil menambah data'
                    ], 201);
                }
            } else {
                return response()->json([
                    'status' => 'failed',
                    'pesan' => 'Gagal menambah guru'
                ], 200);
            }
        }
    }
}
