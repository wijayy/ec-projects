<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HakAkses extends Model
{
    /** @use HasFactory<\Database\Factories\HakAksesFactory> */
    use HasFactory, Sluggable;

    public function getRouteKeyName()
    {
        return 'slug';
    }

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
    protected $guarded = ['id'];

    public function roleHakAkses(): HasMany
    {
        return $this->hasMany(RolesHakAkses::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_hak_akses');
    }
}