<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Http\Requests\UpdateStokRequest;
use App\Models\Stok;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::latest()->get();
        return view('produk.index', compact('produk'));
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
    public function store(StoreProdukRequest $request)
    {
        $validated = $request->validateWithBag('tambahProduk', $request->rules());
        try {
            DB::beginTransaction();
            $produk = Produk::create(['nama' => $validated['nama'], 'deskripsi' => $validated['deskripsi']]);

            foreach ($validated['variasi'] as $key => $item) {
                $item['produk_id'] = $produk->id;
                Stok::create($item);
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

        return back()->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdukRequest $request, Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStok(UpdateStokRequest $request, Produk $produk)
    {
        $validated = $request->validateWithBag('tambahStok', $request->rules());
        // dd($validated);
        try {
            DB::beginTransaction();

            foreach ($validated['variasi'] as $key => $item) {
                Stok::where('id', $item['id'])->update($item);
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

        return back()->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        //
    }
}
