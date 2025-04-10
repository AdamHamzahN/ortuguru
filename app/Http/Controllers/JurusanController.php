<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class JurusanController extends Controller
{
    public function adminDaftarJurusan()
    {
        return view('admin.jurusan.index');
    }

    public function tambahJurusan()
    {
        return view('admin.jurusan.tambah');
    }

    public function editJurusan(Request $request)
    {
        if ($request->id) {
            $jurusan = DB::table('jurusan')
                ->leftJoin('guru', 'jurusan.kepala_program_id', '=', 'guru.id')
                ->leftJoin('user', 'guru.user_id', '=', 'user.id')
                ->select('jurusan.*', 'guru.nip', 'user.nama as nama_kepala_program')
                ->where('jurusan.id', $request->id)
                ->first();

            if ($jurusan) {
                return view('admin.jurusan.edit', [
                    'jurusan' => $jurusan,
                    'nama_kepala_program' => $jurusan->guru->user->nama ?? ''
                ]);
            } else {
                return view('not_found');
            }
        } else {
            return view('not_found');
        }
    }

    public function simpan(Request $request)
    {
        $data = $request->validate([
            'id',
            'nama_jurusan' => ['required'],
            'kepala_program_id' => ['required']
        ]);

        $idExist = Jurusan::where('id', $request['id'])->exists();

        if ($idExist) {
            $updateData = Jurusan::where('id', '=', $request->id)->update($data);
            if ($updateData) {
                return response()->json([
                    'status' => 'success',
                    'pesan' => 'Data Berhasil Diupdate'
                ], 201);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'pesan' => 'Data Gagal Diupdate'
                ], 200);
            }
        } else {
            $kepalaprogramexist = Jurusan::where('kepala_program_id', $request['kepala_program_id'])->exists();

            if ($kepalaprogramexist) {
                return response()->json([
                    'status' => 'failed',
                    'pesan' => 'Guru tersebut sudah menjadi kepala program'
                ], 200);
            } else {
                $createData = Jurusan::create($data);

                if ($createData) {
                    return response()->json([
                        'status' => 'success',
                        'pesan' => 'Data Berhasil Ditambahkan'
                    ], 201);
                } else {
                    return response()->json([
                        'status' => 'failed',
                        'pesan' => 'Data Gagal Ditambahkan'
                    ], 200);
                }
            }
        }
    }

    public function dataJurusan()
    {
        $data = Jurusan::leftJoin('guru', 'jurusan.kepala_program_id', '=', 'guru.id')
            ->leftJoin('user as user_guru', 'guru.user_id', '=', 'user_guru.id')
            ->leftJoin('kelas', 'jurusan.id', '=', 'kelas.jurusan_id')

            // Join siswa dengan kondisi kelas belum lulus
            ->leftJoin('siswa', function ($join) {
                $join->on('kelas.id', '=', 'siswa.kelas_id')
                    ->where('kelas.status', '=', 'belum lulus');
            })

            // Join orang tua dari siswa
            ->leftJoin('orang_tua_siswa', 'siswa.orang_tua_id', '=', 'orang_tua_siswa.id')

            // Join ke user ortu, filter status aktif
            ->leftJoin('user as user_ortu', function ($join) {
                $join->on('orang_tua_siswa.user_id', '=', 'user_ortu.id')
                    ->where('user_ortu.status', '=', 'aktif');
            })

            ->select(
                'jurusan.id',
                'jurusan.nama_jurusan',
                'user_guru.nama as kepala_program',
                DB::raw('COUNT(DISTINCT siswa.id) as jumlah_siswa')
            )
            ->groupBy('jurusan.id', 'jurusan.nama_jurusan', 'user_guru.nama');

        return DataTables::of($data)
            ->filterColumn('kepala_program', function ($query, $keyword) {
                $query->where('user_guru.nama', 'like', "%{$keyword}%");
            })
            ->filterColumn('jumlah_siswa', function ($query, $keyword) {
                $query->havingRaw("COUNT(DISTINCT siswa.id) like ?", ["%{$keyword}%"]);
            })
            ->make(true);
    }
}
