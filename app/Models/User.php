<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $fillable = ['id','nama', 'email', 'password','role_id'];
    public $timestamps = true;
    public $incrementing = false;
    protected $keyType = 'string';

    // menjalan kan function ketika model diakses (create, update, delete)
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
