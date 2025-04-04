<?php

namespace App\Exports;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AkunGuruExport implements FromCollection, WithHeadings, WithMapping
{
    protected $defaultPassword;

    public function __construct()
    {
        $this->defaultPassword = env('DEFAULT_PASSWORD', 'password123'); // fallback kalau belum di-set
    }

    public function collection()
    {
        $gururole = Role::where('nama', 'Guru')->value('id');

        return DB::table('user')
            ->leftJoin('guru', 'guru.user_id', '=', 'user.id')
            ->where('user.role_id', $gururole)
            ->select('user.nama', 'user.email')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'Password',
        ];
    }

    public function map($row): array
    {
        return [
            $row->nama,
            $row->email,
            $this->defaultPassword
        ];
    }
}
