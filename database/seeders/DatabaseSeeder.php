<?php

namespace Database\Seeders;

use App\Models\HakAkses;
use App\Models\Produk;
use App\Models\ProdukFoto;
use App\Models\Provinsi;
use App\Models\Role;
use App\Models\RolesHakAkses;
use App\Models\Stok;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\TransaksiFoto;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@admin.com',
            'is_admin' => true
        ]);

        $provinsi = [
            "Bali",
            "Aceh",
            "Sumatera Utara",
            "Sumatera Barat",
            "Riau",
            "Jambi",
            "Sumatera Selatan",
            "Bengkulu",
            "Lampung",
            "Kepulauan Bangka Belitung",
            "Kepulauan Riau",
            "DKI Jakarta",
            "Jawa Barat",
            "Jawa Tengah",
            "DI Yogyakarta",
            "Jawa Timur",
            "Banten",
            "Nusa Tenggara Barat",
            "Nusa Tenggara Timur",
            "Kalimantan Barat",
            "Kalimantan Tengah",
            "Kalimantan Selatan",
            "Kalimantan Timur",
            "Kalimantan Utara",
            "Sulawesi Utara",
            "Sulawesi Tengah",
            "Sulawesi Selatan",
            "Sulawesi Tenggara",
            "Gorontalo",
            "Sulawesi Barat",
            "Maluku",
            "Maluku Utara",
            "Papua",
            "Papua Barat",
            "Papua Selatan",
            "Papua Tengah",
            "Papua Pegunungan",
            "Papua Barat Daya"
        ];
        foreach ($provinsi as $key => $value) {
            Provinsi::factory(1)->create(['nama' => $value]);
        }

        Produk::factory(20)->create();
        Stok::factory(100)->recycle(Produk::all())->create();
        ProdukFoto::factory(100)->recycle(Produk::all())->create();

        Transaksi::factory(500)->recycle(Provinsi::all())->create();
        TransaksiDetail::factory(1000)->recycle([Transaksi::all(), Stok::all()])->create();
        TransaksiFoto::factory(1000)->recycle(Transaksi::all())->create();

        User::factory(5)->create();
        // Role::factory(5)->create();
        $permission = [
            [
                'nama' =>  "create-produk",
                'deskripsi' => "Menambahkan produk baru ke dalam sistem"
            ],
            [
                'nama' =>  "edit-produk",
                'deskripsi' => "Mengedit informasi produk yang sudah ada"
            ],
            [
                'nama' =>  "delete-produk",
                'deskripsi' => "Menghapus produk dari sistem"
            ],
            [
                'nama' =>  "update-stok",
                'deskripsi' => "Memperbarui jumlah stok produk"
            ],

            [
                'nama' =>  "create-transaksi",
                'deskripsi' => "Membuat transaksi baru"
            ],
            [
                'nama' =>  "edit-transaksi",
                'deskripsi' => "Mengedit transaksi yang sudah ada"
            ],
            [
                'nama' =>  "delete-transaksi",
                'deskripsi' => "Menghapus transaksi dari sistem"
            ],
            [
                'nama' =>  "show-transaksi",
                'deskripsi' => "Melihat detail transaksi"
            ],

            [
                'nama' =>  "dashboard",
                'deskripsi' => "Mengakses dan melihat halaman dashboard utama"
            ],
            [
                'nama' =>  "analitik",
                'deskripsi' => "Melihat laporan dan analisis data"
            ]
        ];

        foreach ($permission as $key => $item) {
            HakAkses::factory(1)->create($item);
        }

        foreach (Role::all() as $key => $role) {
            foreach (HakAkses::all() as $key => $hakAkses) {
                RolesHakAkses::factory(1)->recycle([$role, $hakAkses])->create();
            }
        }
    }
}