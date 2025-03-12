<?php

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
    $stok = Produk::whereHas('stok', function ($query) {
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

    Route::resource('produk', ProdukController::class)->only('index', 'store', 'update', 'delete');
    Route::resource('transaksi', TransaksiController::class);
    Route::post('produk/{produk}/update-stok', [ProdukController::class, 'updateStok'])->name('produk.update-stok');
    Route::get('download/{file}', function (TransaksiFoto $file) {
        $filePath = public_path('storage/' . $file->file); // Path file// Nama file yang akan diunduh
        return response()->download($filePath, $file->filename);
    })->name('download');

    Route::resource('role', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('analitik', function () {
        return view('analitik');
    })->name('analitik');
});

require __DIR__ . '/auth.php';