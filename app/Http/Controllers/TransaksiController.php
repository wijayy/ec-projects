<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use App\Models\Produk;
use App\Models\Provinsi;
use App\Models\Stok;
use App\Models\TransaksiDetail;
use App\Models\TransaksiFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksi = Transaksi::latest()->filters(request(['provinsi', 'status', 'platform', 'selesai']));
        $popup = Transaksi::latest()->filters(request(['provinsi', 'status', 'platform', 'selesai']));

        if ((request()->get('bulan') ?? date('n')) != 0) {
            // dd(request(['bulan']));
            $transaksi->filters(['bulan' => request('bulan', date('n'))]);
            $popup->filters(['bulan' => request(['bulan'], date('n'))]);
        }
        if ((request()->get('tahun') ?? date('Y')) != 'semua') {
            $transaksi->filters(['tahun' => request('tahun', date('Y'))]);
            $popup->filters(['tahun' => request('tahun', date('Y'))]);
        }

        $transaksi = $transaksi->get();
        $popup = $popup->whereDate('selesai', date('Y-m-d'))->whereNot('status', 'selesai')->count();

        $provinsi = Provinsi::all();
        $stok = Stok::orderBy('produk_id',)->get();
        // latest()->fil->get();
        return view('transaksi.index', compact('transaksi', 'provinsi', 'stok', 'popup'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransaksiRequest $request)
    {
        $validated = $request->validateWithBag('tambahTransaksi', $request->rules());
        // dd($request->file('files'));
        try {
            DB::beginTransaction();
            $validated['nomor_transaksi'] = date('Ymd') . fake()->randomLetter() . fake()->randomLetter() . fake()->randomLetter();
            $validated['nomor_transaksi'] = strtoupper($validated['nomor_transaksi']);

            $transaksi = Transaksi::create($validated);

            foreach ($validated['produk'] as $key => $item) {
                $item['transaksi_id'] = $transaksi->id;
                $stok = Stok::find($item['produk_id']);
                $item['nama'] = $stok->produk->nama;
                $item['deskripsi'] = $stok->produk->deskripsi;
                $item['size'] = $stok->size;
                $item['color'] = $stok->color;
                $item['arm'] = $stok->arm;
                $item['harga'] = $stok->harga;

                $stok->decrement('stok', $item['qty']);

                TransaksiDetail::create($item);
            }
            if (!is_null($validated['files'])) {
                // dd('masuk 1');
                foreach ($validated['files'] as $key => $item) {
                    $item['transaksi_id'] = $transaksi->id;

                    // Simpan file dengan index yang sesuai
                    if (isset($request->file('files')[$key])) {
                        // dd('masuk 2');
                        $item['file'] = $request->file('files')[$key]['file']->store('file');
                        $item['filename'] = $request->file('files')[$key]['file']->getClientOriginalName();
                        TransaksiFoto::create($item);
                    }
                }
                // dd('masuk 3');
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }

        return back()->with('success', "transaksi berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransaksiRequest $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        if ($transaksi->status == 'success') {
            return back()->with("error", "Transaksi tidak bisa dihapus");
        }
        try {
            DB::beginTransaction();
            $path = [];


            foreach ($transaksi->transaksiDetail as $key => $item) {
                $item->delete();
            }
            foreach ($transaksi->transaksiFoto as $key => $item) {
                $path[] = $item->file;
                $item->delete();
            }
            $transaksi->delete();
            DB::commit();

            foreach ($path as $item) {
                Storage::delete($item);
            }

            return back()->with('success', "Transaksi berhasil dihapus");
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
    }
}