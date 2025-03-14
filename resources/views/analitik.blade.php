<x-app-layout title="Analitik">
    <div class="grid grid-cols-1 gap-10 lg:grid-cols-2">
        <div class="">
            <h2 class="text-lg text-center lg:text-xl">Analisis Penjualan per Bulan pada Tahun tertentu</h2>
            <form id="yearForm" class="flex items-center" method="GET">
                <x-input-label class="w-1/4" for="year">Pilih Tahun:</x-input-label>
                <x-select-input name="year" id="year" onchange="this.form.submit()">
                    @foreach ($years1 as $year)
                        <x-select-option value="{{ $year }}" :selected="$year == $selectedYear">
                            {{ $year }}
                        </x-select-option>
                    @endforeach
                </x-select-input>
            </form>

            <!-- Canvas untuk Grafik -->
            <div class="w-full">
                <canvas id="graph1" class=""></canvas>
            </div>
        </div>

        <div class="">
            <h2 class="text-lg text-center lg:text-xl">Analisis Penjualan per Tahun pada Bulan tertentu</h2>

            <!-- Form untuk memilih bulan -->
            <form id="monthForm" class="flex items-center" method="GET">
                <x-input-label class="w-1/4" for="month">Pilih Bulan:</x-input-label>
                <x-select-input name="month" id="month" onchange="this.form.submit()">
                    @foreach ([
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ] as $num => $name)
                        <x-select-option value="{{ $num }}" :selected="$num == $selectedMonth">
                            {{ $name }}
                        </x-select-option>
                    @endforeach
                </x-select-input>
            </form>

            <!-- Canvas untuk Grafik -->
            <div class="w-full">
                <canvas id="graph2"></canvas>
            </div>
        </div>

        <div class="">
            <h2 class="text-lg text-center lg:text-xl">Jumlah Transaksi per Bulan pada Tahun tertentu</h2>

            <!-- Form untuk memilih tahun -->
            <form id="yearForm" class="flex items-center" method="GET">
                <x-input-label class="w-1/4" for="year">Pilih Tahun:</x-input-label>
                <x-select-input name="year" id="year" onchange="this.form.submit()">
                    @foreach ($years3 as $year)
                        <x-select-option value="{{ $year }}" :selected="$year == $selectedYear">
                            {{ $year }}
                        </x-select-option>
                    @endforeach
                </x-select-input>
            </form>

            <!-- Canvas untuk Grafik -->
            <div class="w-full">
                <canvas id="graph3"></canvas>
            </div>
        </div>

        <div class="">
            <h2 class="text-lg text-center lg:text-xl">Jumlah Transaksi per Tahun dalam Bulan tertentu</h2>

            <!-- Form untuk memilih bulan -->
            <form id="monthForm" class="flex" method="GET">
                <label for="month">Pilih Bulan:</label>
                <x-select-input name="month" id="month" onchange="this.form.submit()">
                    @foreach ([
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ] as $num => $name)
                        <x-select-option value="{{ $num }}" :selected="$num == $selectedMonth">
                            {{ $name }}
                        </x-select-option>
                    @endforeach
                </x-select-input>
            </form>

            <!-- Canvas untuk Grafik -->
            <canvas id="graph4"></canvas>
        </div>

    </div>
    <div class="overflow-x-auto">
        <h2 class="text-lg text-center lg:text-xl">Analisis Penjualan per Platform per Bulan pada Tahun tertentu
        </h2>

        <!-- Form untuk memilih tahun -->
        <form id="yearForm" class="flex" method="GET">
            <label for="year">Pilih Tahun:</label>
            <x-select-input name="year" id="year" onchange="this.form.submit()">
                @foreach ($years5 as $year)
                    <x-select-option value="{{ $year }}" :selected="$year == $selectedYear">
                        {{ $year }}
                    </x-select-option>
                @endforeach
            </x-select-input>
        </form>

        <!-- Canvas untuk Grafik -->
        <div class="w-full  min-w-[700px]: aspect-square">
            <canvas id="graph5"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Data dari query PHP
            let labels1 = @json($labels1); // ['Januari', 'Februari', 'Maret', ...]
            let dataPenjualan1 = @json($data1); // [500000, 800000, 1200000, ...]

            // Inisialisasi Chart.js
            const ctx1 = document.getElementById('graph1').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: labels1,
                    datasets: [{
                        label: 'Total Penjualan (Rp)',
                        data: dataPenjualan1,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            let labels2 = @json($labels2);
            let dataPenjualan2 = @json($data2);

            const ctx2 = document.getElementById('graph2').getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: labels2,
                    datasets: [{
                        label: 'Total Penjualan (Rp)',
                        data: dataPenjualan2,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            let labels3 = @json($labels3);
            let data3 = @json($data3);

            const ctx3 = document.getElementById('graph3').getContext('2d');
            new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: labels3.map(b => new Date(0, b - 1).toLocaleString('id-ID', {
                        month: 'long'
                    })),
                    datasets: [{
                        label: 'Jumlah Transaksi',
                        data: data3,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            let labels4 = @json($labels4);
            let data4 = @json($data4);

            const ctx4 = document.getElementById('graph4').getContext('2d');
            new Chart(ctx4, {
                type: 'bar',
                data: {
                    labels: labels4,
                    datasets: [{
                        label: 'Jumlah Transaksi',
                        data: data4,
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            let labels5 = @json($labels5).map(b => new Date(0, b - 1).toLocaleString('id-ID', {
                month: 'long'
            }));
            let data5 = @json($data5);
            let platforms = @json($platforms);

            // Warna untuk setiap platform
            const colors = {
                offline: 'rgba(255, 99, 132, 0.5)',
                shopee: 'rgba(54, 162, 235, 0.5)',
                tiktok: 'rgba(255, 206, 86, 0.5)',
                tokopedia: 'rgba(75, 192, 192, 0.5)',
                whatsapp: 'rgba(153, 102, 255, 0.5)'
            };

            // Buat dataset untuk setiap platform
            let datasets5 = platforms.map(platform => ({
                label: platform.charAt(0).toUpperCase() + platform.slice(1),
                data: data5[platform],
                backgroundColor: colors[platform],
                borderColor: colors[platform].replace('0.5', '1'),
                borderWidth: 1
            }));

            const ctx5 = document.getElementById('graph5').getContext('2d');
            new Chart(ctx5, {
                type: 'bar',
                data: {
                    labels: labels5,
                    datasets: datasets5
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Pastikan false agar bisa diubah tinggi
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const ctx6 = document.getElementById("graph6").getContext("2d");

            new Chart(ctx6, {
                type: "bar",
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov",
                        "Des"
                    ],
                    datasets: [{
                            label: "Cash",
                            data: @json($cashSales6),
                            backgroundColor: "rgba(255, 99, 132, 0.6)",
                        },
                        {
                            label: "Transfer",
                            data: @json($transferSales6),
                            backgroundColor: "rgba(54, 162, 235, 0.6)",
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
