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
        $provinsi = Provinsi::all();
        $stok = Stok::orderBy('produk_id',)->get();
        return view('transaksi.create', compact('provinsi', 'stok'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransaksiRequest $request)
    {
        $validated = $request->validated();
        // dd($request->file('files'));
        try {
            DB::beginTransaction();
            $validated['nomor_transaksi'] = date('Ymd') . fake()->randomLetter() . fake()->randomLetter() . fake()->randomLetter();
            $validated['nomor_transaksi'] = strtoupper($validated['nomor_transaksi']);

            $validated['total'] = 0;

            $transaksi = Transaksi::create($validated);
            $total = 0;

            foreach ($validated['produk'] as $key => $item) {
                $item['transaksi_id'] = $transaksi->id;
                $stok = Stok::find($item['produk_id']);
                $total += $stok->harga * $item['qty'];
                $item['stok_id'] = $stok->id;
                $item['arm'] = $stok->arm;
                $item['harga'] = $stok->harga;

                if ($stok->stok < $item['qty']) {
                    throw new \Exception("Jumlah stok Produk {$stok->produk->nama} | {$stok->size} {$stok->color} {$stok->arm}  kurang, silahkan tambahkan stok terlebih dahulu!");
                }
                $stok->decrement('stok', $item['qty']);


                TransaksiDetail::create($item);
            }
            if (!empty($validated['files'])) {
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

            $transaksi->update(['total' => $total * (100 - $transaksi->diskon) / 100]);
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
        return view('transaksi.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        $provinsi = Provinsi::all();
        $stok = Stok::orderBy('produk_id',)->get();
        return view('transaksi.edit', compact('transaksi', 'provinsi', 'stok'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransaksiRequest $request, Transaksi $transaksi)
    {

        $validated = $request->validated();

        // dd($produkIds);
        try {
            DB::beginTransaction();

            $oldDetails = TransaksiDetail::where('transaksi_id', $transaksi->id)->get();

            // Ambil produk baru dari form
            $newProducts = collect($request->produk);

            // Simpan semua produk_id dari transaksi baru
            $newProductIds = $newProducts->pluck('produk_id')->toArray();

            // Loop transaksi lama untuk mengembalikan stok jika produk dihapus atau qty berkurang
            foreach ($oldDetails as $oldItem) {
                if (!in_array($oldItem->produk_id, $newProductIds)) {
                    // Produk dihapus dari transaksi, kembalikan stok sepenuhnya
                    Stok::where('id', $oldItem->produk_id)->increment('stok', $oldItem->qty);
                    $oldItem->delete();
                }
            }

            // Proses setiap produk baru
            foreach ($newProducts as $item) {
                $stok = Stok::findOrFail($item['produk_id']);
                $existingDetail = TransaksiDetail::where('transaksi_id', $transaksi->id)
                    ->where('stok_id', $item['produk_id'])
                    ->first();

                if ($existingDetail) {
                    $diffQty = $item['qty'] - $existingDetail->qty;

                    if ($diffQty > 0) {
                        // Tambah qty, cek apakah stok cukup
                        if ($stok->stok < $diffQty) {
                            throw new \Exception("Stok untuk produk ID {$stok->id} tidak mencukupi!");
                        }
                        $stok->decrement('stok', $diffQty);
                    } elseif ($diffQty < 0) {
                        // Kurangi qty, tambahkan kembali ke stok
                        $stok->increment('stok', abs($diffQty));
                    }

                    // Update transaksi detail
                    $existingDetail->update([
                        'qty' => $item['qty']
                    ]);
                } else {
                    // Produk baru ditambahkan, cek stok dulu
                    if ($stok->stok < $item['qty']) {
                        throw new \Exception("Stok untuk produk {$stok->produk->nama} | {$stok->size} {$stok->color} {$stok->arm} tidak mencukupi!");
                    }
                    $stok->decrement('stok', $item['qty']);

                    TransaksiDetail::create([
                        'transaksi_id' => $transaksi->id,
                        'stok_id' => $item['produk_id'],
                        'qty' => $item['qty'],
                        'harga' => $stok->harga
                    ]);
                }
            }


            // Ambil semua gambar yang ada di database sebelum update
            // Ambil gambar lama dari database
            $gambarLama = $transaksi->transaksiFoto->pluck('file', 'id')->toArray();

            // Simpan daftar gambar baru
            $gambarBaru = [];

            if ($request->has('files')) {
                foreach ($request->input('files') as $index => $fileData) {
                    $idGambar = $fileData['id'] ?? null; // Ambil ID jika ada
                    $file = $request->file("files.$index.image");

                    if ($idGambar && isset($gambarLama[$idGambar])) {
                        // Jika ada ID, berarti ini gambar lama
                        if ($file) {
                            // Jika ada file baru, ganti gambar lama
                            $path = $file->store('produk', 'public');
                            $filename = $file->getClientOriginalName(); // Ambil nama file asli

                            // Hapus gambar lama dari storage
                            Storage::disk('public')->delete($gambarLama[$idGambar]);

                            // Update database (image & filename)
                            $transaksi->transaksiFoto()->where('id', $idGambar)->update([
                                'image' => $path,
                                'filename' => $filename, // Simpan filename
                            ]);

                            // Simpan di daftar gambar baru
                            $gambarBaru[$idGambar] = $path;
                        } else {
                            // Jika tidak ada file baru, pertahankan gambar lama
                            $gambarBaru[$idGambar] = $gambarLama[$idGambar];
                        }
                    } elseif ($file) {
                        // Jika tidak ada ID, berarti ini gambar baru
                        $path = $file->store('produk', 'public');
                        $filename = $file->getClientOriginalName(); // Ambil nama file asli

                        // Simpan ke database (image & filename)
                        $foto = $transaksi->transaksiFoto()->create([
                            'image' => $path,
                            'filename' => $filename, // Simpan filename
                        ]);

                        // Simpan di daftar gambar baru
                        $gambarBaru[$foto->id] = $path;
                    }
                }
            }

            // Cari gambar yang harus dihapus (gambar lama yang tidak ada di input)
            $gambarHapus = array_diff_key($gambarLama, $gambarBaru);

            // Hapus gambar yang tidak ada di input
            foreach ($gambarHapus as $id => $gambar) {
                Storage::disk('public')->delete($gambar);
                $transaksi->transaksiFoto()->where('id', $id)->delete();
            }


            DB::commit();
            return redirect(route('transaksi.index'))->with("success", "Transaksi $transaksi->nomor_transaksi berhasil diupdate");
        } catch (\Throwable $th) {
            DB::rollBack();

            if (!empty($gambarBaru)) {
                # code...
                // Hapus gambar baru yang sudah diupload sebelum error terjadi
                foreach ($gambarBaru as $id => $gambar) {
                    if (!isset($gambarLama[$id])) {
                        Storage::disk('public')->delete($gambar);
                    }
                }
            }

            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
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