<?php

use App\Http\Controllers\AnalitikController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Models\Produk;
use App\Models\Provinsi;
use App\Models\Stok;
use App\Models\Transaksi;
use App\Models\TransaksiFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('/dashboard', function () {
    $transaksi = Transaksi::query();
    $transaksiMonth = Transaksi::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();
    $produk = Produk::all();
    $provinsi = Provinsi::withSum('transaksi', 'total')
        ->orderByDesc('transaksi_sum_total')
        ->take(4)
        ->get();
    $topMonthYear = Transaksi::selectRaw('YEAR(created_at) as year, MONTHNAME(created_at) as month, SUM(total) as total_transaksi')
        ->groupBy('year', 'month')
        ->orderByDesc('total_transaksi')
        ->first();
    $topYear = Transaksi::selectRaw('YEAR(created_at) as year, SUM(total) as total_transaksi')
        ->groupBy('year')
        ->orderByDesc('total_transaksi')
        ->first();
    $data = Transaksi::selectRaw('YEAR(created_at) as year, SUM(total) as total')
        ->groupBy('year')
        ->orderBy('year', 'ASC')
        ->get();
    $years = $data->pluck('year');
    $totals = $data->pluck('total');

    // dd($provinsi);
    $stok = Produk::whereHas('stoks', function ($query) {
        $query->where('stok', '<=', 5);
    })
        ->take(8)
        ->get();
    // dd($stok);
    return view('dashboard', compact('transaksi', 'years', 'totals', 'transaksiMonth', 'topYear', 'topMonthYear', 'provinsi', 'produk', 'stok'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('produk', ProdukController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('produk.show');
    Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    Route::get('/produk/{produk}/update-stok', [ProdukController::class, 'editStok'])->name('produk.edit-stok');
    Route::post('/produk/{produk}/update-stok', [ProdukController::class, 'updateStok'])->name('produk.update-stok');

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{transaksi}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/transaksi/{transaksi}', [TransaksiController::class, 'update'])->name('transaksi.update');
    Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');


    Route::post('produk/{produk}/update-stok', [ProdukController::class, 'updateStok'])->name('produk.update-stok');
    Route::get('download/{file}', function (TransaksiFoto $file) {
        $filePath = public_path('storage/' . $file->file); // Path file// Nama file yang akan diunduh
        return response()->download($filePath, $file->filename);
    })->name('download');

    Route::resource('role', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('analitik', [AnalitikController::class, 'index'])->name('analitik');
});

require __DIR__ . '/auth.php';
