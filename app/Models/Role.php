<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Generate UUID
    public function setIdAttribute($value)
    {
        $this->attributes['id'] = $value ?? Str::uuid();
    }
}
