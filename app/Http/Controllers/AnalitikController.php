<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalitikController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tahun dari request atau gunakan tahun sekarang sebagai default
        $selectedYear = $request->input('year', date('Y'));
        $selectedMonth = $request->input('month', date('m'));
        // Query untuk mendapatkan total penjualan per bulan berdasarkan tahun yang dipilih
        $penjualan = DB::table('transaksis')
            ->selectRaw('MONTH(created_at) as bulan, SUM(total) as total_penjualan')
            ->whereYear('created_at', $selectedYear)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Label bulan
        $labels1 = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        // Konversi hasil query menjadi array untuk grafik
        $data1 = array_fill(0, 12, 0); // Default 0 untuk semua bulan
        foreach ($penjualan as $row) {
            $data1[$row->bulan - 1] = $row->total_penjualan;
        }

        // Ambil daftar tahun transaksi yang tersedia di database
        $years1 = DB::table('transaksis')
            ->selectRaw('DISTINCT YEAR(created_at) as year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Ambil bulan dari request atau gunakan bulan sekarang sebagai default

        // Query untuk mendapatkan total penjualan dari semua tahun berdasarkan bulan yang dipilih
        $penjualan = DB::table('transaksis')
            ->selectRaw('YEAR(created_at) as tahun, SUM(total) as total_penjualan')
            ->whereMonth('created_at', $selectedMonth)
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        // Ambil daftar tahun transaksi yang tersedia di database
        $years2 = DB::table('transaksis')
            ->selectRaw('DISTINCT YEAR(created_at) as year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Label tahun
        $labels2 = $penjualan->pluck('tahun')->toArray();
        $data2 = $penjualan->pluck('total_penjualan')->toArray();

        // Query untuk mendapatkan jumlah transaksi per bulan
        $transactions = DB::table('transaksis')
            ->selectRaw('MONTH(created_at) as bulan, COUNT(id) as jumlah_transaksi')
            ->whereYear('created_at', $selectedYear)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Ambil daftar tahun transaksi yang tersedia
        $years3 = DB::table('transaksis')
            ->selectRaw('DISTINCT YEAR(created_at) as year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Label bulan (1-12) dengan jumlah transaksi
        $labels3 = range(1, 12);
        $data3 = array_fill(0, 12, 0); // Default 0 transaksi per bulan

        foreach ($transactions as $t) {
            $data3[$t->bulan - 1] = $t->jumlah_transaksi;
        }

        // Query untuk mendapatkan jumlah transaksi dari semua tahun berdasarkan bulan yang dipilih
        $transactions = DB::table('transaksis')
            ->selectRaw('YEAR(created_at) as tahun, COUNT(id) as jumlah_transaksi')
            ->whereMonth('created_at', $selectedMonth)
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        // Ambil daftar tahun transaksi yang tersedia
        $years4 = DB::table('transaksis')
            ->selectRaw('DISTINCT YEAR(created_at) as year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Label tahun dan jumlah transaksi
        $labels4 = $transactions->pluck('tahun')->toArray();
        $data4 = $transactions->pluck('jumlah_transaksi')->toArray();

        // Definisi platform yang digunakan
        $platforms = ['offline', 'shopee', 'tiktok', 'tokopedia', 'whatsapp'];

        // Query untuk mendapatkan total penjualan per bulan per platform
        $salesData = DB::table('transaksis')
            ->selectRaw('MONTH(created_at) as bulan, platform, SUM(total) as total_penjualan')
            ->whereYear('created_at', $selectedYear)
            ->groupBy('bulan', 'platform')
            ->orderBy('bulan')
            ->get();

        // Ambil daftar tahun transaksi yang tersedia
        $years5 = DB::table('transaksis')
            ->selectRaw('DISTINCT YEAR(created_at) as year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Data untuk grafik
        $labels5 = range(1, 12);
        $data5 = [];

        // Inisialisasi data platform
        foreach ($platforms as $platform) {
            $data5[$platform] = array_fill(0, 12, 0); // Set semua bulan ke 0
        }

        // Mengisi data berdasarkan hasil query
        foreach ($salesData as $data) {
            $data5[$data->platform][$data->bulan - 1] = $data->total_penjualan;
        }

        $salesData = DB::table('transaksis')
            ->select(
                DB::raw("MONTH(created_at) as month"),
                DB::raw("SUM(CASE WHEN payment = 'cash' THEN total ELSE 0 END) as cash"),
                DB::raw("SUM(CASE WHEN payment = 'transfer' THEN total ELSE 0 END) as transfer")
            )
            ->whereYear('created_at', $selectedYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months6 = range(1, 12);
        $cashSales6 = array_fill(0, 12, 0);
        $transferSales6 = array_fill(0, 12, 0);

        foreach ($salesData as $data) {
            $index = $data->month - 1;
            $cashSales[$index] = $data->cash;
            $transferSales[$index] = $data->transfer;
        }

        $years6 = DB::table('transaksis')->selectRaw('YEAR(created_at) as year')->distinct()->pluck('year');


        return view(
            'analitik',
            compact(
                'labels1',
                'data1',
                'years1',
                'selectedYear',
                'selectedMonth',
                'years2',
                'labels2',
                'data2',
                'years3',
                'data3',
                'labels3',
                'years4',
                'data4',
                'labels4',
                'platforms',
                'years5',
                'data5',
                'labels5',
                'months6',
                'years6',
                'cashSales6',
                'transferSales6',
            )
        );
    }
}