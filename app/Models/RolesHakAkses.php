<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesHakAkses extends Model
{
    /** @use HasFactory<\Database\Factories\RolesHakAksesFactory> */
    use HasFactory;
    protected $guarded = ['id'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hakAkses()
    {
        return $this->belongsTo(HakAkses::class);
    }
}