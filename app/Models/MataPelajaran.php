<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nama_pelajaran'];
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
