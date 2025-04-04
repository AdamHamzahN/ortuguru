<?php

namespace App\Exports;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class DataGuruExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $gururole = Role::where('nama', 'Guru')->value('id');

        return DB::table('user')
            ->leftJoin('guru', 'guru.user_id', '=', 'user.id')
            ->where('user.role_id', $gururole)
            ->select(
                'user.nama', 
                'guru.nip',
                'guru.agama',
                'guru.jenis_kelamin',
                'guru.tempat_lahir',
                'guru.tanggal_lahir',
                'guru.nomor_telepon',
                'guru.alamat',
                'user.email',
                'user.status'
                )
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIP',
            'Agama',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Alamat',
            'Nomor Telepon',
            'Email',
            'Status'
        ];
    }
}
