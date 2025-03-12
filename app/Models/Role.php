<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Role extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory, Sluggable;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $guarded = ['id'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }

    protected $with = ['user'];

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function roleHakAkses(): HasMany
    {
        return $this->hasMany(RolesHakAkses::class);
    }

    public function hakAkses()
    {
        return $this->belongsToMany(
            HakAkses::class,
            'roles_hak_akses',  // Nama tabel pivot
            'role_id',          // FK di tabel pivot yang mengacu ke roles
            'hak_akses_id'     // FK di tabel pivot yang mengacu ke hak_akses
        );
    }
}