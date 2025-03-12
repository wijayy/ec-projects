<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    /** @use HasFactory<\Database\Factories\TransaksiFactory> */
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
                'source' => 'nomor_transaksi'
            ]
        ];
    }
    protected $guarded = ['id'];
    protected $with = ['transaksiDetail', 'transaksiFoto'];

    public function transaksiDetail(): HasMany
    {
        return $this->hasMany(transaksiDetail::class);
    }

    public function transaksiFoto(): HasMany
    {
        return $this->hasMany(transaksiFoto::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function scopeFilters(Builder  $query, array $filters)
    {
        $query->when($filters["bulan"] ?? false, function ($query, $search) {
            return $query->whereMonth("created_at", $search);
        });

        $query->when($filters["tahun"] ?? false, function ($query, $search) {
            return $query->whereYear("created_at", $search);
        });

        $query->when($filters["platform"] ?? false, function ($query, $search) {
            return $query->where("platform", $search);
        });
        $query->when($filters["selesai"] ?? false, function ($query, $search) {
            return $query->where("selesai", $search);
        });
        $query->when($filters["status"] ?? false, function ($query, $search) {
            return $query->where("status", $search);
        });

        $query->when($filters["provinsi"] ?? false, function ($query, $search) {
            return $query->whereHas("provinsi", function ($query) use ($search) {
                $query->where("slug", $search);
            });
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'selesai' => 'datetime:Y-m-d',
        ];
    }
}