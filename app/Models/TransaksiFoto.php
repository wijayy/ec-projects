<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiFoto extends Model
{
    /** @use HasFactory<\Database\Factories\TransaksiFotoFactory> */
    use HasFactory;
    protected $guarded = ['id'];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}