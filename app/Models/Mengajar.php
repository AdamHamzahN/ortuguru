<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Mengajar extends Model
{
    protected $table = 'mengajar';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'guru_id', 'mata_pelajaran_id'];
    public $timestamps = false;
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
