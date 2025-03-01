<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $fillable = ['kode_transaksi', 'tanggal'];

    public function detail() {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}
