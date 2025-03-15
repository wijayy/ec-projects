<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stok extends Model
{
    /** @use HasFactory<\Database\Factories\StokFactory> */
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $with = ['transaksiDetail'];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }

    public function transaksiDetail(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    public function scopeFilters(Builder  $query, array $filters)
    {
        $query->when($filters["size"] ?? false, function ($query, $search) {
            return $query->where("size", $search);
        });
        $query->when($filters["color"] ?? false, function ($query, $search) {
            return $query->where("color", $search);
        });
        $query->when($filters["arm"] ?? false, function ($query, $search) {
            return $query->where("arm", $search);
        });


        $query->when($filters["produk_id"] ?? false, function ($query, $search) {
            return $query->whereHas("produk", function ($query) use ($search) {
                $query->where("id", $search);
            });
        });
    }
}