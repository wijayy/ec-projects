@php
    $bulan = [
        0 => 'Semua',
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    $status = ['belum diproses', 'diproses', 'selesai'];
    $platform = [
        'offline' => 'bg-white',
        'shopee' => 'bg-[#EE4D2D]',
        'tiktok' => 'bg-black text-white',
        'tokopedia' => 'bg-[#42b549]',
        'whatsapp' => 'bg-[#25d366]',
    ];
@endphp

<x-app-layout title="Semua Transaksi">
    <div class="flex flex-wrap justify-between w-full gap-4">
        <div class="flex items-center gap-4">
            <div class="text-sm text-wrap lg:text-nowrap">Statistik Penjualan</div>
            <form method="GET" class="flex items-center gap-4 w-fit">
                <x-select-input class="m-0" required id="bulan" name="bulan" class="w-32">
                    @foreach ($bulan as $item)
                        <x-select-option :selected="$loop->index == (request('bulan') ?? date('n'))"
                            value="{{ $loop->index }}">{{ $item }}</x-select-option>
                    @endforeach
                </x-select-input>
                <x-select-input class="m-0" required id="tahun" name="tahun" class="w-20 ">
                    <x-select-option value="semua">Semua</x-select-option>
                    @for ($i = date('Y'); $i >= 2025; $i--)
                        <x-select-option :selected="$i == (request('tahun') ?? date('Y'))"
                            value="{{ $i }}">{{ $i }}</x-select-option>
                    @endfor
                </x-select-input>

                <x-action-a class="p-3 bg-mine-200" x-data=""
                    @click.prevent="$el.closest('form').submit()">
                    <x-action-label>cari</x-action-label>
                    <i class='text-xl bx bx-search-alt'></i>
                </x-action-a>
            </form>
        </div>
        <x-primary-a href="{{ route('transaksi.create') }}" class="items-center gap-2 h-fit" x-data="">

            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path d="M4 12H9M12 12H20M12 4V20" stroke="#000000" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                </g>
            </svg><span>Tambah Transaksi</span></x-primary-a>
    </div>
    <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="flex items-center w-full h-20 p-4 rounded-lg min-h-40 shadow-mine">
            <div class="flex items-center justify-center w-1/4 h-full">
                <svg width="64px" height="64px" viewBox="0 0 48 48" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <rect width="48" height="48" fill="white" fill-opacity="0.01"></rect>
                        <path
                            d="M37 17V37M11 37V44H37V37M11 37H4V17C4 14 6 10.5 9 8C12 5.5 16 4 16 4H32C32 4 36 5.5 39 8C42 10.5 44 14 44 17V37H37M11 37V17"
                            stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M24 17V44" stroke="#000000" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M24 17L16 4" stroke="#000000" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M32 4L24 17" stroke="#000000" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                </svg>
            </div>
            <div class="flex flex-col items-center w-3/4">
                <div class="text-xl text-center md:text-2xl text-wrap">Total Transaksi</div>
                <div class="text-5xl text-mine-200">{{ $transaksi->count() }} </div>
            </div>
        </div>
        <div class="flex items-center w-full h-20 p-4 rounded-lg min-h-40 shadow-mine">
            <div class="flex items-center justify-center w-1/4 h-full">
                <svg width="64px" height="64px" viewBox="0 0 48 48" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <rect width="48" height="48" fill="white" fill-opacity="0.01"></rect>
                        <path
                            d="M37 17V37M11 37V44H37V37M11 37H4V17C4 14 6 10.5 9 8C12 5.5 16 4 16 4H32C32 4 36 5.5 39 8C42 10.5 44 14 44 17V37H37M11 37V17"
                            stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M24 17V44" stroke="#000000" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M24 17L16 4" stroke="#000000" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M32 4L24 17" stroke="#000000" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                </svg>
            </div>
            <div class="flex flex-col items-center w-3/4">
                <div class="text-xl text-center md:text-2xl text-wrap">Transaksi Selesai</div>
                <div class="text-5xl text-mine-200">{{ $transaksi->where('status', 'selesai')->count() }} </div>
            </div>
        </div>
        <div class="flex items-center w-full h-20 p-4 rounded-lg min-h-40 shadow-mine">
            <div class="flex items-center justify-center w-1/4 h-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="64px" height="64px" viewBox="0 0 24 24"
                    fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                        <path
                            d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z">
                        </path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </g>
                </svg>
            </div>
            <div class="flex flex-col items-center w-3/4">
                <div class="text-xl text-center md:text-2xl text-wrap">Total Produk Terjual</div>
                <div class="text-5xl text-mine-200">{{ $transaksi->sum('diskon') }} </div>
            </div>
        </div>

        <div class="flex items-center w-full h-20 p-4 rounded-lg min-h-40 shadow-mine">
            <div class="flex items-center justify-center w-1/4 h-full">
                <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" width="64px" height="64px"
                    viewBox="0 0 76.991 76.992" xml:space="preserve">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <g>
                            <g>
                                <g>
                                    <g>
                                        <path
                                            d="M46.387,75.839h-5.812c-0.639,0-1.24-0.248-1.692-0.697c-0.458-0.463-0.707-1.063-0.707-1.701l0.016-51.524 c0-0.64,0.25-1.243,0.703-1.696c0.456-0.454,1.058-0.702,1.696-0.702l5.604,0.008c1.32,0.005,2.394,1.079,2.396,2.394v0.048 c2.803-2.202,6.19-3.28,10.262-3.28c10.512,0,18.14,8.825,18.14,20.983c0,15.145-9.986,22.042-19.265,22.042 c-3.352,0-6.428-0.868-8.94-2.491v14.219C48.786,74.763,47.71,75.839,46.387,75.839z M41.176,72.839h4.61V56.038 c0-0.615,0.375-1.167,0.946-1.396c0.572-0.227,1.225-0.082,1.646,0.367c2.247,2.387,5.566,3.702,9.349,3.702 c7.834,0,16.265-5.959,16.265-19.042c0-10.42-6.367-17.983-15.14-17.983c-4.492,0-7.957,1.571-10.588,4.803 c-0.398,0.492-1.063,0.68-1.664,0.467c-0.597-0.211-0.998-0.775-1-1.409l-0.008-3.023l-4.4-0.006L41.176,72.839z M57.816,54.72 c-6.789,0-12.313-6.51-12.313-14.51s5.524-14.509,12.313-14.509c6.791,0,12.316,6.509,12.316,14.509S64.607,54.72,57.816,54.72z M57.816,28.702c-5.135,0-9.313,5.163-9.313,11.509s4.179,11.51,9.313,11.51c5.138,0,9.316-5.164,9.316-11.51 S62.954,28.702,57.816,28.702z">
                                        </path>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path
                                            d="M34.844,56.259H28.25c-1.124,0-2.137-0.709-2.52-1.768l-7.107-19.626h-6.889v18.713c0,1.478-1.202,2.681-2.68,2.681 H2.681C1.203,56.259,0,55.056,0,53.579V3.873c0-1.475,1.199-2.677,2.673-2.681l12.233-0.04c7.523,0,12.485,1.457,16.095,4.722 c3.068,2.707,4.765,6.748,4.765,11.365c0,6.011-1.837,10.229-6.297,14.32l7.885,21.082c0.305,0.825,0.19,1.744-0.305,2.461 C36.543,55.829,35.72,56.259,34.844,56.259z M28.474,53.259h5.909l-8.084-21.615c-0.221-0.59-0.049-1.254,0.429-1.665 c4.402-3.772,6.039-7.226,6.039-12.741c0-3.744-1.336-6.986-3.764-9.128c-3.031-2.742-7.373-3.959-14.091-3.959L3.001,4.19 v49.069h5.733V33.366c0-0.829,0.671-1.5,1.5-1.5h9.441c0.631,0,1.195,0.396,1.41,0.989L28.474,53.259z M15.575,27.669h-5.341 c-0.829,0-1.5-0.671-1.5-1.5V9.927c0-0.828,0.67-1.499,1.498-1.5l5.117-0.006c0.004-0.001,0.012,0,0.019,0 c9.64,0.107,11.664,5.253,11.664,9.552C27.031,23.772,22.427,27.669,15.575,27.669z M11.734,24.669h3.841 c5.216,0,8.456-2.566,8.456-6.697c0-2.77-0.9-6.462-8.688-6.552l-3.609,0.004V24.669z">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
            </div>
            <div class="flex flex-col items-center w-3/4">
                <div class="text-xl text-center md:text-2xl text-wrap">Total Transaksi</div>
                <div class="text-5xl text-mine-200">
                    {{ number_format($transaksi->sum('total') / 1000, 0, ',', '.') . 'K' }} </div>
            </div>
        </div>

    </div>
    <form class="flex flex-wrap items-end w-full gap-4 mt-4 md:flex-nowrap h-fit">
        <div class="grid w-full grid-cols-2 gap-4 lg:w-3/4 lg:grid-cols-4">
            @if (request(['bulan']) ?? false)
                <input type="hidden" name="bulan" value="{{ request()->get('bulan') }}">
            @endif
            @if (request(['tahun']) ?? false)
                <input type="hidden" name="tahub" value="{{ request()->get('tahun') }}">
            @endif
            <div class="w-full">
                <x-input-label :required="false" for="provinsi" :value="__('provinsi')" />
                <x-select-input id="provinsi" class="text-base" name="provinsi">
                    <x-select-option value="">Pilih</x-select-option>
                    @foreach ($provinsi as $item)
                        <x-select-option :selected="$item->slug == request('provinsi')"
                            value="{{ $item->slug }}">{{ $item->nama }}</x-select-option>
                    @endforeach
                </x-select-input>
            </div>
            <div class="w-full">
                <x-input-label :required="false" for="status" :value="__('status')" />
                <x-select-input id="status" class="text-base" name="status">
                    <x-select-option value="">Pilih</x-select-option>
                    @foreach ($status as $item)
                        <x-select-option :selected="$item == request('status')"
                            value="{{ $item }}">{{ $item }}</x-select-option>
                    @endforeach
                </x-select-input>
            </div>
            <div class="w-full">
                <x-input-label :required="false" for="platform" :value="__('platform')" />
                <x-select-input id="platform" class="text-base" name="platform">
                    <x-select-option value="">Pilih</x-select-option>
                    @foreach ($platform as $key => $item)
                        <x-select-option :selected="$key == request('platform')"
                            value="{{ $key }}">{{ $key }}</x-select-option>
                    @endforeach
                </x-select-input>
            </div>
            <div class="w-full">
                <x-input-label :required="false" for="selesai" :value="__('estimasi selesai')" />
                <x-text-input id="selesai" class="block w-full mt-1" type="date" name="selesai"
                    :value="request()->get('selesai')" autocomplete="selesai" />
            </div>
        </div>
        <div class="flex gap-4 w-fit flex-nowrap">
            <x-primary-button>Filter</x-primary-button>
            <x-primary-a href="{{ route('transaksi.index') }}"
                class="bg-mine-300 hover:bg-mine-300">Reset</x-primary-a>
        </div>
    </form>

    <div class="mt-4 overflow-x-auto ">
        <table class="table-auto shadow-mine border-spacing-4 border-separate min-w-[1400px] w-full">
            <thead>
                <tr>
                    <th>No Transaksi</th>
                    <th>Customer</th>
                    <th>Produk</th>
                    <th>Diskon</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Status Pembayaran</th>
                    <th>Platform Transaksi</th>
                    <th>Provinsi</th>
                    <th>Estimasi Selesai</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi as $item)
                    <tr class="gap-4 space-y-4 text-xs text-center rounded-lg md:text-base">
                        <td>{{ $item->nomor_transaksi }} </td>
                        <td>{{ $item->customer }} </td>
                        <td>
                            <div class="flex flex-wrap w-full gap-2 min-w-48 max-w-96">
                                @foreach ($item->transaksiDetail as $itm)
                                    <div class="p-1 rounded bg-mine-100">{{ $itm->stok->produk->nama }} |
                                        {{ $itm->stok->size }}
                                        {{ $itm->stok->color ?? false ? "- {$itm->stok->color}" : '' }}
                                        {{ $itm->stok->arm ?? false ? "- {$itm->stok->arm}" : '' }} |
                                        {{ $itm->qty }} Pcs </div>
                                @endforeach
                            </div>
                        </td>
                        <td>{{ $item->diskon }}% </td>
                        <td>{{ number_format(((100 - $item->diskon) * $item->total) / 100000, 0, ',', '.') . 'K' }}
                        </td>
                        <td>{{ $item->status }} </td>
                        <td>{{ $item->lunas ? 'Lunas' : 'DP ' . number_format($item->dp / 1000, 0, ',', '.') . 'K' }}
                        </td>
                        <td>{{ $item->platform }} </td>
                        <td>{{ $item->provinsi->nama }} </td>
                        <td>{{ $item->selesai?->format('d-m-Y') ?? '-' }} </td>
                        <td>
                            <div class="flex gap-2">
                                <x-action-a href="{{ route('transaksi.show', ['transaksi' => $item->slug]) }}"
                                    x-data="" class="bg-mine-200 ">
                                    <x-action-label>Tampilkan</x-action-label>
                                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M3 14C3 9.02944 7.02944 5 12 5C16.9706 5 21 9.02944 21 14M17 14C17 16.7614 14.7614 19 12 19C9.23858 19 7 16.7614 7 14C7 11.2386 9.23858 9 12 9C14.7614 9 17 11.2386 17 14Z"
                                                stroke="#000000" stroke-width="1" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                </x-action-a>
                                @if ($item->status != 'selesai')
                                    <x-action-a x-data=""
                                        href="{{ route('transaksi.edit', ['transaksi' => $item->slug]) }}"
                                        class="bg-yellow-400">
                                        <x-action-label>Edit</x-action-label>
                                        <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M11 4H7.2C6.0799 4 5.51984 4 5.09202 4.21799C4.71569 4.40974 4.40973 4.7157 4.21799 5.09202C4 5.51985 4 6.0799 4 7.2V16.8C4 17.9201 4 18.4802 4.21799 18.908C4.40973 19.2843 4.71569 19.5903 5.09202 19.782C5.51984 20 6.0799 20 7.2 20H16.8C17.9201 20 18.4802 20 18.908 19.782C19.2843 19.5903 19.5903 19.2843 19.782 18.908C20 18.4802 20 17.9201 20 16.8V12.5M15.5 5.5L18.3284 8.32843M10.7627 10.2373L17.411 3.58902C18.192 2.80797 19.4584 2.80797 20.2394 3.58902C21.0205 4.37007 21.0205 5.6364 20.2394 6.41745L13.3774 13.2794C12.6158 14.0411 12.235 14.4219 11.8012 14.7247C11.4162 14.9936 11.0009 15.2162 10.564 15.3882C10.0717 15.582 9.54378 15.6885 8.48793 15.9016L8 16L8.04745 15.6678C8.21536 14.4925 8.29932 13.9048 8.49029 13.3561C8.65975 12.8692 8.89125 12.4063 9.17906 11.9786C9.50341 11.4966 9.92319 11.0768 10.7627 10.2373Z"
                                                    stroke="#000000" stroke-width="1" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </g>
                                        </svg>
                                    </x-action-a>
                                    <x-action-a class="cursor-pointer bg-rose-500" x-data=""
                                        @click.prevent="$dispatch('open-modal', 'hapus-transaksi-{{ $loop->iteration }}')">
                                        <x-action-label>Hapus</x-action-label>
                                        <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17"
                                                    stroke="#000000" stroke-width="1" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </g>
                                        </svg>
                                    </x-action-a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($transaksi as $item)
        @if ($item->status != 'selesai')
            <x-modal name="hapus-transaksi-{{ $loop->iteration }}" :title="'Hapus Transaksi ' . $item->nomor_transaksi" :show="false" focusable>
                <form method="post" action="{{ route('transaksi.destroy', ['transaksi' => $item->slug]) }}"
                    class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __("Yakin ingin menghapus transaksi $item->nomor_transaksi?") }}
                    </h2>

                    <div class="flex justify-end mt-6">
                        <x-secondary-button @click="$dispatch('close')">
                            {{ __('Batal') }}
                        </x-secondary-button>

                        <x-danger-button class="ms-3">
                            {{ __('Hapus Transaksi') }}
                        </x-danger-button>
                    </div>
                </form>
            </x-modal>
        @endif
    @endforeach

    <x-modal name="popup-notifikasi" class="flex items-center" :title="'Info!'" :maxWidth="'sm'"
        :show="$popup">
        <div class="">Terdapat {{ $popup }} transaksi yang harus diselesaikan hari ini!</div>
    </x-modal>


    <script></script>
</x-app-layout>
