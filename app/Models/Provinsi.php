<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provinsi extends Model
{
    /** @use HasFactory<\Database\Factories\ProvinsiFactory> */
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

    protected $with = ['transaksi'];

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }
}