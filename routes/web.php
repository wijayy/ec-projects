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
})->middleware(['auth', 'verified', 'permission:dashboard'])->name('dashboard');

// Route::resource('produk', ProdukController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index')->middleware('permission:create-produk,edit-produk,delete-produk,update-stok');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create')->middleware('permission:create-produk');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store')->middleware('permission:create-produk');
    // Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('produk.show')->middleware('permission:');
    Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit')->middleware('permission:edit-produk');
    Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update')->middleware('permission:edit-produk');
    Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy')->middleware('permission:delete-produk');
    Route::get('/produk/{produk}/update-stok', [ProdukController::class, 'editStok'])->name('produk.edit-stok')->middleware('permission:update-stok');
    Route::post('/produk/{produk}/update-stok', [ProdukController::class, 'updateStok'])->name('produk.update-stok')->middleware('permission:update-stok');

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index')->middleware('permission:create-transaksi,edit-transaksi,delete-transaksi');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create')->middleware('permission:create-transaksi');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store')->middleware('permission:create-transaksi');
    Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show')->middleware('permission:show-transaksi');
    Route::get('/transaksi/{transaksi}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit')->middleware('permission:edit-transaksi');
    Route::put('/transaksi/{transaksi}', [TransaksiController::class, 'update'])->name('transaksi.update')->middleware('permission:edit-transaksi');
    Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy')->middleware('permission:delete-transaksi');


    // Route::post('produk/{produk}/update-stok', [ProdukController::class, 'updateStok'])->name('produk.update-stok')->middleware('permission:');
    Route::get('download/{file}', function (TransaksiFoto $file) {
        $filePath = public_path('storage/' . $file->file); // Path file// Nama file yang akan diunduh
        return response()->download($filePath, $file->filename);
    })->name('download')->middleware('permission:show-transaksi');
    Route::get('analitik', [AnalitikController::class, 'index'])->name('analitik')->middleware('permission:analitik');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('role', RoleController::class);
    Route::resource('users', UserController::class);
});

require __DIR__ . '/auth.php';