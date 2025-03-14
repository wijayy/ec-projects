<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Http\Requests\UpdateStokRequest;
use App\Models\ProdukFoto;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::latest()->paginate(12);
        return view('produk.index', compact('produk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validateWithBag('tambahProduk', [
            'nama' => "required|string",
            'deskripsi' => "required|string",
            'size' => "required|string",
            'color' => "nullable|string",
            "arm" => 'nullable|array',
            "files" => 'present|array',
            "variasi" => 'nullable|array',
            'variasi.*.size' => 'nullable|string',
            'variasi.*.arm' => 'nullable|string',
            'variasi.*.color' => 'nullable|string',
            'variasi.*.harga' => 'nullable|integer',
            'variasi.*.stok' => 'nullable|integer',
            'files.*.image' => 'nullable|file',
        ]);
        try {
            DB::beginTransaction();
            // Mengubah array 'arm' menjadi string dengan pemisah ","
            $validated['arm'] = isset($validated['arm']) ? implode(',', $validated['arm']) : null;

            $produk = Produk::create($validated);

            foreach ($validated['variasi'] as $key => $item) {
                $item['produk_id'] = $produk->id;
                Stok::create($item);
            }

            if (!is_null($validated['files'])) {
                // dd('masuk 1');
                foreach ($validated['files'] as $key => $item) {
                    $item['produk_id'] = $produk->id;

                    // Simpan file dengan index yang sesuai
                    if (isset($request->file('files')[$key])) {
                        // dd('masuk 2');
                        $item['image'] = $request->file('files')[$key]['image']->store('file');
                        $item['filename'] = $request->file('files')[$key]['image']->getClientOriginalName();
                        ProdukFoto::create($item);
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

        return redirect(route('produk.index'))->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validateWithBag('editProduk', [
            'nama' => "required|string",
            'deskripsi' => "required|string",
            'size' => "required|string",
            'color' => "nullable|string",
            "arm" => 'nullable|array',
            "files" => 'present|array',
            "variasi" => 'nullable|array',
            'variasi.*.size' => 'nullable|string',
            'variasi.*.arm' => 'nullable|string',
            'variasi.*.color' => 'nullable|string',
            'variasi.*.harga' => 'nullable|integer',
            'variasi.*.stok' => 'nullable|integer',
            'files.*.image' => 'nullable|file',
        ]);

        try {
            DB::beginTransaction();
            $produk->stoks->each(function ($item) {
                $item->delete();
            });
            // $produk->produkFoto->delete();


            foreach ($validated['variasi'] as $key => $item) {
                $item['produk_id'] = $produk->id;

                Stok::create($item);
            }

            // Ambil semua gambar yang ada di database sebelum update
            // Ambil gambar lama dari database
            $gambarLama = $produk->produkFoto->pluck('image', 'id')->toArray();

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
                            $produk->produkFoto()->where('id', $idGambar)->update([
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
                        $foto = $produk->produkFoto()->create([
                            'image' => $path,
                            'filename' => $filename, // Simpan filename
                        ]);

                        // Simpan di daftar gambar baru
                        $gambarBaru[$foto->id] = $path;
                    }
                }
            }

            $validated['arm'] = isset($validated['arm']) ? implode(',', $validated['arm']) : null;

            $produk->update($validated);
            // Jika berhasil, cari gambar yang harus dihapus (ada di database tetapi tidak ada di form)

            // Cari gambar yang harus dihapus (gambar lama yang tidak ada di input)
            $gambarHapus = array_diff_key($gambarLama, $gambarBaru);

            // Hapus gambar yang tidak ada di input
            foreach ($gambarHapus as $id => $gambar) {
                Storage::disk('public')->delete($gambar);
                $produk->produkFoto()->where('id', $id)->delete();
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            // Hapus gambar baru yang sudah diupload sebelum error terjadi
            foreach ($gambarBaru as $id => $gambar) {
                if (!isset($gambarLama[$id])) {
                    Storage::disk('public')->delete($gambar);
                }
            }
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }



        return back()->with('success', 'Produk berhasil diedit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editStok(Produk $produk)
    {
        return view('produk.update-stok', compact('produk'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function updateStok(Request $request, Produk $produk)
    {
        $validated = $request->validateWithBag('tambahStok', [
            "variasi" => 'nullable|array',
            'variasi.*.size' => 'required|string',
            'variasi.*.arm' => 'nullable|string',
            'variasi.*.color' => 'nullable|string',
            'variasi.*.harga' => 'required|integer',
            'variasi.*.stok' => 'required|integer',
        ]);
        // dd($validated);
        try {
            DB::beginTransaction();

            foreach ($validated['variasi'] as $key => $item) {
                $item['produk_id'] = $produk->id;
                $stok = Stok::filters($item)->update($item);
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

        return back()->with('success', 'Stok berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        //
    }
}
