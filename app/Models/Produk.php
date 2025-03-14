<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    /** @use HasFactory<\Database\Factories\ProdukFactory> */
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
                'source' => 'nama',
                'onUpdate' => true
            ]
        ];
    }

    protected $guarded = ['id'];
    protected $with = ['stoks', 'produkFoto'];

    public function stoks(): HasMany
    {
        return $this->hasMany(Stok::class);
    }
    public function produkFoto(): HasMany
    {
        return $this->hasMany(ProdukFoto::class);
    }
}