<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Case1Controller extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        $transaksi = Transaksi::all();
        return view('menu.case1',compact('produk','transaksi'));
    }
}
