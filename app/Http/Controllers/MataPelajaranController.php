<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MataPelajaranController extends Controller
{
    public function adminDaftarMataPelajaran()
    {
        return view('admin.mata-pelajaran.index');
    }

    public function tambahMataPelajaran()
    {
        return view('admin.mata-pelajaran.tambah');
    }

    public function editMataPelajaran(Request $request)
    {
        if ($request->id) {
            $mata_pelajaran = MataPelajaran::find($request->id);

            if ($mata_pelajaran) {
                return view('admin.mata-pelajaran.edit', ['mata_pelajaran' => $mata_pelajaran]);
            } else {
                return view('not_found');
            }
        } else {
            return view('not_found'); // atau redirect back
        }
    }

    public function simpan(Request $request)
    {
        $data = $request->validate([
            'id',
            'nama_pelajaran' => ['required'],
        ]);

        $idExist = MataPelajaran::where('id', $request['id'])->exists();

        if ($idExist) {
            $updateData = MataPelajaran::where('id', '=', $request->id)->update($data);
            if ($updateData) {
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
        } else {
            $createData = MataPelajaran::create($data);

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

    public function dataMataPelajaran()
    {
        $data = DB::table('mata_pelajaran')
            ->leftJoin('mengajar', 'mata_pelajaran.id', '=', 'mengajar.mata_pelajaran_id')
            ->leftJoin('guru', 'mengajar.guru_id', '=', 'guru.id')
            ->select(
                'mata_pelajaran.id',
                'mata_pelajaran.nama_pelajaran as mata_pelajaran',
                DB::raw('COUNT(DISTINCT guru.id) as jumlah_guru')
            )
            ->groupBy('mata_pelajaran.id', 'mata_pelajaran.nama_pelajaran')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function listMataPelajaran(Request $request)
    {
        $search = $request->input('q');

        $query = DB::table('mata_pelajaran')->select('id', 'nama_pelajaran');

        if ($search) {
            $query->where('nama_pelajaran', 'like', '%' . $search . '%');
        }

        $data = $query->limit(5)->get();

        $formatted = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->nama_pelajaran,
            ];
        });

        return response()->json(['results' => $formatted]);
    }
}
