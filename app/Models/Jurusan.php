<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Jurusan extends Model
{
    protected $table = 'jurusan';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nama_jurusan', 'kepala_program_id'];
    public $timestamps = true;
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            // Jika id kosong, maka generate sebuah id baru
            if (empty($model->id)) {
                // membuat id otomatis terisi 
                $model->id = Str::uuid();
            }
        });
    }
}
