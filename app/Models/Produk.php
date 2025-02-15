<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $fillable = ['produk', 'stok', 'harga'];

    public function detailTransaksi() {
        return $this->hasMany(DetailTransaksi::class, 'id_produk');
    }
}
