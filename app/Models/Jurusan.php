<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';
    protected $primaryKey = 'id';
    // protected $fillable = ['id', 'nama', 'email', 'password', 'role_id'];
    public $timestamps = true;
    public $incrementing = false;
    protected $keyType = 'string';
}
