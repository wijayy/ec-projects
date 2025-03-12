<x-app-layout title="Dashboard">
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 ">
        <a class="flex flex-col items-center justify-center h-32 p-4 rounded-lg lg:h-52 shadow-mine">
            <div class="text-lg font-semibold lg:text-2xl">Total Produk</div>
            <div class="text-3xl font-semibold lg:text-6xl">{{ $produk->count() }} Pcs</div>
        </a>
        <a class="flex flex-col items-center justify-center h-32 p-4 rounded-lg lg:h-52 shadow-mine">
            <div class="text-lg font-semibold lg:text-2xl">Transaksi Bulan ini</div>
            <div class="text-3xl font-semibold lg:text-6xl">{{ $transaksiMonth->count() }} </div>
        </a>
        <a class="flex flex-col items-center justify-center h-32 p-4 rounded-lg lg:h-52 shadow-mine">
            <div class="text-lg font-semibold lg:text-2xl">Transaksi Bulan Ini</div>
            <div class="text-3xl font-semibold lg:text-6xl">IDR
                {{ number_format($transaksiMonth->sum('total') / 1000, 0, ',', '.') . 'K' }}</div>
        </a>
    </div>

    <div class="grid w-full grid-cols-1 gap-4 mt-4 h-fit md:grid-cols-2">
        <div class="w-full h-fit min-h-72">
            <div class="text-xl">Transaksi Belum Selesai</div>
            <table class="w-full border border-collapse rounded-lg table-auto border-mine-200">
                <thead>
                    <tr>
                        <th class="p-1 text-center border border-mine-200">Nomor Transaksi</th>
                        <th class="p-1 text-center border border-mine-200">Estimasi Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi->whereNot('status', 'selesai')->orderBy('selesai', 'DESC')->take(8)->get() as $item)
                        <tr>
                            <td class="p-1 text-center border border-mine-200">{{ $item->nomor_transaksi }} </td>
                            <td class="p-1 text-center border border-mine-200">{{ $item->selesai?->format('d-m-Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('transaksi.index') }}" class="flex items-center mt-2 hover:animate-bounce">Semua Transaksi
                <i class="text-xl bx bx-right-arrow-alt"></i></a>
        </div>
        <div class="w-full h-fit min-h-72">
            <div class="text-xl">Produk</div>
            <table class="w-full border table-auto border-mine-200">
                <thead>
                    <tr>
                        <th class="p-1 text-center border border-mine-200">Produk</th>
                        <th class="p-1 text-center border border-mine-200">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @dd($stok) --}}
                    @foreach ($stok as $item)
                        <tr>
                            <td class="p-1 text-center border border-mine-200">{{ $item->nama }} </td>
                            <td class="p-1 text-center border border-mine-200">
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($item->stok->where('stok', '<=', 5) as $itm)
                                        <div
                                            class="px-1 rounded h-fit shadow-mine  {{ $itm->stok <= 5 ? 'bg-mine-300 text-white' : 'bg-mine-100' }}">
                                            {{ $itm->size }} {{ $itm->color ? "- $itm->color" : '' }}
                                            {{ $itm->arm ? "- $itm->arm" : '' }} |
                                            {{ $itm->stok }} Pcs
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('produk.index') }}" class="flex items-center mt-2 hover:animate-bounce">Semua Produk <i
                    class="text-xl bx bx-right-arrow-alt"></i></a>
        </div>
    </div>

    <div class="flex flex-wrap gap-4 mt-4 md:flex-nowrap">
        <div class="w-full space-y-2 md:w-1/4 h-fit md:h-52 ">
            <div class="">Top Provinsi</div>
            @foreach ($provinsi as $item)
                @php
                    if ($loop->index == 0) {
                        $base = $item->transaksi_sum_total;
                    }
                    $width = number_format(($item->transaksi_sum_total / $base) * 100, 0, ',', '.') . '%';
                @endphp
                <div class="flex justify-between px-3 py-1 rounded-lg bg-gradient-to-r from-mine-300"
                    style="width: {{ $width }}">
                    <div class="">{{ $item->nama }} </div>
                    <div class="">{{ number_format($item->transaksi_sum_total / 1000, 0, ',', '.') . 'K' }}
                    </div>
                </div>
            @endforeach
        </div>
        <div class="w-full space-y-2 md:w-2/4 h-fit md:h-52">
            <div class="">Pertumbuhan Transaksi</div>
            <canvas class="" id="growthChart">

            </canvas>

        </div>
        <div class="w-1/4 h-fit md:h-52 ">
            <div class="">
                <div class="text-lg font-semibold text-gray-400">Top Month</div>
                <div class="text-3xl font-bold">{{ $topMonthYear->month }} </div>
                <div class="text-2xl text-mine-300">{{ $topMonthYear->year }}</div>
            </div>
            <div class="">
                <div class="text-lg font-semibold text-gray-400">Top Year</div>
                <div class="text-3xl font-bold text-mine-300">{{ $topYear->year }}</div>
                <div class="text-2xl ">{{ number_format($topYear->total_transaksi / 1000, 0, ',', '.') . 'K' }} sold so
                    far</div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const labels = @json($years);
            const data = @json($totals);

            const canvas = document.getElementById('growthChart');
            const ctx = canvas.getContext('2d');
            canvas.width = canvas.clientWidth;
            canvas.height = canvas.clientHeight;

            // 🔹 Buat gradien dari atas ke bawah
            let gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
            gradient.addColorStop(0, 'rgba(255, 99, 132, 0.8)');
            gradient.addColorStop(1, 'rgba(255, 99, 132, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Total Transaksi",
                        data: data,
                        borderColor: 'salmon',
                        borderDash: [5, 5],
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.3,
                        pointRadius: 3,
                        pointBackgroundColor: 'tomato'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value >= 1000 ? value / 1000 + 'k' : value;
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
