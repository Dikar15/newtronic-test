<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::all();
        return view('transaksi.index', compact('produk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|array',
            'id_produk.*' => 'exists:produk,id',
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:1',
        ]);

        DB::beginTransaction();
        try {

            $transaksi = Transaksi::create([
                'kode_transaksi' => 'TRX' . date('YmdHis'),
                'tanggal' => now()
            ]);

            foreach ($request->id_produk as $index => $id_produk) {
                $produk = Produk::findOrFail($id_produk);
                $quantity = $request->quantity[$index];


                if ($produk->stok < $quantity) {
                    return redirect()->back()->withErrors([
                        'stok' => "Stok untuk produk {$produk->produk} tidak mencukupi!"
                    ])->withInput();
                }

                $produk->stok -= $quantity;
                $produk->save();

                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id,
                    'id_produk' => $produk->id,
                    'quantity' => $quantity
                ]);
            }

            DB::commit();
            return redirect()->route('menu.case1')->with('success-transaksi', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transaksi = Transaksi::with('detail')->findOrFail($id);

        $produk = Produk::all();

        $detail = $transaksi->detail->keyBy('id_produk');

        return view('transaksi.edit', compact('transaksi', 'produk', 'detail','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        DB::transaction(function () use ($request, $transaksi) {
            foreach ($request->input('produk') as $produkId => $quantity) {
                $detail = $transaksi->detail()->where('id_produk', $produkId)->first();

                if ($detail) {
                    $produk = Produk::findOrFail($produkId);
                    if ($quantity > $produk->stok + $detail->quantity) {
                        return back()->withErrors([
                            'Stok tidak cukup untuk produk: ' . $produk->produk
                        ]);
                    }

                    $produk->stok += $detail->quantity;
                    $produk->stok -= $quantity;
                    $produk->save();

                    $detail->quantity = $quantity;
                    $detail->save();
                }
                else if ($quantity > 0) {
                    $produk = Produk::findOrFail($produkId);

                    if ($quantity > $produk->stok) {
                        return back()->withErrors([
                            'Stok tidak cukup untuk produk: ' . $produk->produk
                        ]);
                    }

                    $produk->decrement('stok', $quantity);

                    $transaksi->detail()->create([
                        'id_produk' => $produkId,
                        'quantity' => $quantity,
                    ]);
                }
            }
        });

        return redirect()->back()->with('success-transaksi', 'Transaksi berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        DB::beginTransaction();
        try {
            $transaksi->detail()->delete();

            $transaksi->delete();

            DB::commit();

            return redirect()->route('menu.case1')->with('success-transaksi', 'Transaksi dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('menu.case1')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function detil($id)
    {
        $detailTransaksi = Transaksi::with('detail.produk')->findOrFail($id);;
        return view('transaksi.detil', compact('detailTransaksi', 'id'));
    }

    public function detilDestroy($id)
    {
        $detailTransaksi = DetailTransaksi::findOrFail($id);
        $detailTransaksi->delete();

        return redirect()->back()->with('success-transaksi', 'Detail Transaksi berhasil dihapus.');
    }
}
