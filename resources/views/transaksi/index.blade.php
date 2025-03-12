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
        <x-primary-button class="items-center gap-2 h-fit" x-data=""
            @click.prevent="$dispatch('open-modal', 'tambah-transaksi')">

            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path d="M4 12H9M12 12H20M12 4V20" stroke="#000000" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                </g>
            </svg><span>Tambah Transaksi</span></x-primary-button>
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
                <x-input-label for="provinsi" :value="__('provinsi')" />
                <x-select-input id="provinsi" class="text-base" name="provinsi">
                    <x-select-option value="">Pilih</x-select-option>
                    @foreach ($provinsi as $item)
                        <x-select-option :selected="$item->slug == request('provinsi')"
                            value="{{ $item->slug }}">{{ $item->nama }}</x-select-option>
                    @endforeach
                </x-select-input>
            </div>
            <div class="w-full">
                <x-input-label for="status" :value="__('status')" />
                <x-select-input id="status" class="text-base" name="status">
                    <x-select-option value="">Pilih</x-select-option>
                    @foreach ($status as $item)
                        <x-select-option :selected="$item == request('status')"
                            value="{{ $item }}">{{ $item }}</x-select-option>
                    @endforeach
                </x-select-input>
            </div>
            <div class="w-full">
                <x-input-label for="platform" :value="__('platform')" />
                <x-select-input id="platform" class="text-base" name="platform">
                    <x-select-option value="">Pilih</x-select-option>
                    @foreach ($platform as $key => $item)
                        <x-select-option :selected="$key == request('platform')"
                            value="{{ $key }}">{{ $key }}</x-select-option>
                    @endforeach
                </x-select-input>
            </div>
            <div class="w-full">
                <x-input-label for="selesai" :value="__('estimasi selesai')" />
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
        <table class="table-auto shadow-mine border-spacing-4 border-separate min-w-[1200px] w-full">
            <thead>
                <tr>
                    <th>No Transaksi</th>
                    <th>Customer</th>
                    <th>Produk</th>
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
                                    <div class="p-1 rounded bg-mine-100">{{ $itm->nama }} | {{ $itm->size }}
                                        {{ $itm->color ?? false ? "- $itm->color" : '' }}
                                        {{ $itm->arm ?? false ? "- $itm->arm" : '' }} | {{ $itm->qty }} Pcs </div>
                                @endforeach
                            </div>
                        </td>
                        <td>{{ $item->status }} </td>
                        <td>{{ $item->lunas ? 'Lunas' : "DP $item->dp" }} </td>
                        <td>{{ $item->platform }} </td>
                        <td>{{ $item->provinsi->nama }} </td>
                        <td>{{ $item->selesai?->format('d-m-Y') }} </td>
                        <td>
                            <div class="flex gap-2">
                                <x-action-a href="" x-data=""
                                    @click.prevent="$dispatch('open-modal', 'show-transaksi-{{ $loop->iteration }}')"
                                    class="bg-mine-200 ">
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
                                        @click.prevent="$dispatch('open-modal', 'edit-transaksi-{{ $loop->iteration }}')"
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
        <x-modal name="show-transaksi-{{ $loop->iteration }}" :maxWidth="'5xl'" :title="'Detail Transaksi ' . $item->nomor_transaksi">
            <div class="flex gap-2">
                <div class="w-2/3">
                    <div class="grid grid-cols-1 gap-2 lg:grid-cols-2">
                        <div class="w-full">
                            <x-input-label for="customer" :value="__('nama customer')" />
                            <x-input-show>{{ $item->customer }} </x-input-show>
                        </div>
                        <div class="w-full">
                            <x-input-label for="provinsi" :value="__('provinsi')" />
                            <x-input-show>{{ $item->provinsi->nama }} </x-input-show>
                        </div>
                    </div>
                    <div class="w-full">
                        <x-input-label for="catatan" :value="__('catatan')" />
                        <x-input-show>{{ $item->catatan }} </x-input-show>
                    </div>
                    <div class="mt-4 space-y-2">
                        <x-input-label for="Produk" class="w-full" :value="__('Produk')" />
                        @foreach ($item->transaksiDetail as $itm)
                            <div class="flex items-center w-full gap-2">
                                <x-input-show class="w-full">{{ $itm->nama }} | {{ $itm->size }}
                                    {{ $itm->color ? "- $itm->color" : '' }} {{ $itm->arm ? "- $itm->arm" : '' }} |
                                    {{ $itm->qty }} Pcs
                                </x-input-show>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 space-y-2">
                        <x-input-label for="File" class="w-full" :value="__('File')" />
                        <div class="grid grid-cols-2 gap-2 lg:grid-cols-4">
                            @foreach ($item->transaksiFoto as $itm)
                                <div class="relative w-full aspect-square">
                                    @php
                                        $filePath = storage_path('app/public/' . $itm->file);
                                        $isImage = in_array(pathinfo($itm->file, PATHINFO_EXTENSION), [
                                            'jpg',
                                            'jpeg',
                                            'png',
                                            'gif',
                                            'webp',
                                        ]);
                                    @endphp

                                    @if ($isImage)
                                        <div class="relative w-full bg-center bg-no-repeat bg-cover rounded-lg aspect-square"
                                            style="background-image: url({{ asset('storage/' . $itm->file) }})">

                                        </div>
                                    @else
                                        <div
                                            class="relative flex items-center justify-center w-full p-2 bg-gray-200 rounded-lg aspect-square">
                                            <span class="text-sm text-gray-700">{{ $itm->filename }}</span>
                                        </div>
                                    @endif
                                    <div class="absolute top-0 z-30 p-1 -translate-x-full cursor-pointer left-full ">
                                        <x-action-a href="{{ route('download', ['file' => $itm->id]) }}"
                                            class="size-10 bg-mine-200">
                                            <x-action-label>Download</x-action-label>
                                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        d="M5.625 15C5.625 14.5858 5.28921 14.25 4.875 14.25C4.46079 14.25 4.125 14.5858 4.125 15H5.625ZM4.875 16H4.125H4.875ZM19.275 15C19.275 14.5858 18.9392 14.25 18.525 14.25C18.1108 14.25 17.775 14.5858 17.775 15H19.275ZM11.1086 15.5387C10.8539 15.8653 10.9121 16.3366 11.2387 16.5914C11.5653 16.8461 12.0366 16.7879 12.2914 16.4613L11.1086 15.5387ZM16.1914 11.4613C16.4461 11.1347 16.3879 10.6634 16.0613 10.4086C15.7347 10.1539 15.2634 10.2121 15.0086 10.5387L16.1914 11.4613ZM11.1086 16.4613C11.3634 16.7879 11.8347 16.8461 12.1613 16.5914C12.4879 16.3366 12.5461 15.8653 12.2914 15.5387L11.1086 16.4613ZM8.39138 10.5387C8.13662 10.2121 7.66533 10.1539 7.33873 10.4086C7.01212 10.6634 6.95387 11.1347 7.20862 11.4613L8.39138 10.5387ZM10.95 16C10.95 16.4142 11.2858 16.75 11.7 16.75C12.1142 16.75 12.45 16.4142 12.45 16H10.95ZM12.45 5C12.45 4.58579 12.1142 4.25 11.7 4.25C11.2858 4.25 10.95 4.58579 10.95 5H12.45ZM4.125 15V16H5.625V15H4.125ZM4.125 16C4.125 18.0531 5.75257 19.75 7.8 19.75V18.25C6.61657 18.25 5.625 17.2607 5.625 16H4.125ZM7.8 19.75H15.6V18.25H7.8V19.75ZM15.6 19.75C17.6474 19.75 19.275 18.0531 19.275 16H17.775C17.775 17.2607 16.7834 18.25 15.6 18.25V19.75ZM19.275 16V15H17.775V16H19.275ZM12.2914 16.4613L16.1914 11.4613L15.0086 10.5387L11.1086 15.5387L12.2914 16.4613ZM12.2914 15.5387L8.39138 10.5387L7.20862 11.4613L11.1086 16.4613L12.2914 15.5387ZM12.45 16V5H10.95V16H12.45Z"
                                                        fill="#000000"></path>
                                                </g>
                                            </svg>
                                        </x-action-a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="w-1/3">
                </div>
            </div>
        </x-modal>
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
            <x-modal name="edit-transaksi-{{ $loop->iteration }}" :maxWidth="'5xl'" :title="'Edit Transaksi ' . $item->nomor_transaksi"
                :show="false" focusable>
                <form action="{{ route('transaksi.update', ['transaksi' => $item->slug]) }}"
                    enctype="multipart/form-data" method="post" class="flex flex-wrap gap-4 md:flex-nowrap"
                    x-data="{
                        items: {{ json_encode($item->transaksiDetail) ?? '[]' }},

                        addItem() {
                            this.items.push({
                                produk_id: 0,
                                qty: 0,
                                price: 0,
                            });
                        },
                        removeItem(index) {
                            this.items.splice(index, 1);
                        },
                        updatePrice(index) {
                            let select = document.querySelectorAll('[id=produk_id]')[index];
                            let harga = select.options[select.selectedIndex].getAttribute('data-harga');
                            this.items[index].price = harga ? parseFloat(harga) : 0;
                        },
                        get totalPrice() {
                            return this.items.reduce((sum, item) => sum + (item.price * item.qty), 0);
                        }
                    }">
                    @csrf
                    @method('put')
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }} </li>
                    @endforeach


                    <div class="w-full md:w-2/3">

                        <div class="grid w-full grid-cols-1 gap-4 lg:grid-cols-2">
                            <div class="w-full">
                                <x-input-label for="customer" :value="__('nama customer')" />
                                <x-text-input id="customer" class="block w-full mt-1" type="text"
                                    name="customer" :value="old('customer')" required autofocus autocomplete="customer" />

                                <x-input-error :messages="$errors->tambahTransaksi->get('customer')" class="mt-2" />
                            </div>
                            <div class="w-full">
                                <x-input-label for="provinsi_id" :value="__('provinsi')" />
                                <x-select-input name="provinsi_id" id="provinsi_id">
                                    @foreach ($provinsi as $item)
                                        <x-select-option value="{{ $item->id }}"
                                            :selected="old('provinsi_id') == $item->id">{{ $item->nama }}
                                        </x-select-option>
                                    @endforeach
                                </x-select-input>

                                <x-input-error :messages="$errors->tambahTransaksi->get('size')" class="mt-2" />
                            </div>
                        </div>
                        <div class="w-full">
                            <x-input-label for="catatan" :value="__('nama catatan')" />
                            <textarea
                                class="w-full p-1 mt-1 border rounded-md shadow-sm h-fit border-mine-200 focus:border-indigo-500 focus:ring-mine-200"
                                name="catatan" id="catatan" cols="20" rows="2">{{ old('catatan', '') }}</textarea>
                            <x-input-error :messages="$errors->tambahTransaksi->get('catatan')" class="mt-2" />
                        </div>

                        <div class="space-y-2">
                            <!-- Input Fields -->
                            <template x-for="(item, index) in items" :key="index">
                                <div class="flex items-end gap-2" x-init="updatePrice(index)">
                                    <div class="w-4/5">
                                        <x-input-label for="produk_id" :value="__('Produk')" />
                                        <x-select-input @change="updatePrice(index)" ::name="'produk[' + index + '][produk_id]'"
                                            x-model="item.produk_id" id="produk_id">
                                            @foreach ($stok as $item)
                                                <x-select-option :data-harga="$item->harga" value="{{ $item->produk_id }}"
                                                    :selected="old('produk_id') == $item->produk_id">{{ "{$item->produk->nama} | {$item->size} " }}
                                                    {{ $itm->color ?? false ? "- $itm->color" : '' }}
                                                    {{ $itm->arm ?? false ? "- $itm->arm" : '' }}
                                                </x-select-option>
                                            @endforeach
                                        </x-select-input>

                                        <x-input-error :messages="$errors->tambahTransaksi->get('size')" class="mt-2" />
                                    </div>
                                    <div class="w-1/5">
                                        <x-input-label for="qty" :value="__('Qty')" />
                                        <x-text-input @input="updatePrice(index)" id="qty"
                                            class="block w-full mt-1" type="number" ::name="'produk[' + index + '][qty]'"
                                            x-model="item.qty" :value="old('qty')" required autofocus
                                            autocomplete="qty" />
                                        <x-input-error :messages="$errors->tambahTransaksi->get('qty')" class="mt-2" />
                                    </div>
                                    <x-action-a class="p-1 cursor-pointer size-10 bg-rose-500" x-data=""
                                        @click.prevent="removeItem">
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
                                </div>
                            </template>

                            <!-- Tombol Tambah Input -->
                            <button type="button" @click="addItem"
                                class="flex justify-center w-full mt-2 text-white border border-black border-dashed rounded h-7">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M12 6C12.5523 6 13 6.44772 13 7V11H17C17.5523 11 18 11.4477 18 12C18 12.5523 17.5523 13 17 13H13V17C13 17.5523 12.5523 18 12 18C11.4477 18 11 17.5523 11 17V13H7C6.44772 13 6 12.5523 6 12C6 11.4477 6.44772 11 7 11H11V7C11 6.44772 11.4477 6 12 6Z"
                                            fill="#000000"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2 4.5C2 3.11929 3.11929 2 4.5 2H19.5C20.8807 2 22 3.11929 22 4.5V19.5C22 20.8807 20.8807 22 19.5 22H4.5C3.11929 22 2 20.8807 2 19.5V4.5ZM4.5 4C4.22386 4 4 4.22386 4 4.5V19.5C4 19.7761 4.22386 20 4.5 20H19.5C19.7761 20 20 19.7761 20 19.5V4.5C20 4.22386 19.7761 4 19.5 4H4.5Z"
                                            fill="#000000"></path>
                                    </g>
                                </svg>
                            </button>
                        </div>
                        <div x-data="{
                            items: {{ json_encode($item->transaksiFoto) ?? '[]' }},

                            addItem() {
                                this.items.push({
                                    file: '',

                                });
                            },
                            removeItem(index) {
                                this.items.splice(index, 1);
                            }
                        }" class="mt-4 space-y-2">
                            <!-- Input Fields -->
                            <div class="grid items-end grid-cols-2 gap-2 md:grid-cols-4">
                                <template x-for="(item, index) in items" :key="index">
                                    <div class="relative" x-data="{
                                        image: '',
                                        text: 'file ' + (index + 1),
                                        label: 'file' + (index + 1),
                                        lbl: true,
                                        fileName: '',
                                        imagePreview(event) {
                                            const file = event.target.files[0];
                                            if (!file) {
                                                this.lbl = true;
                                                return;
                                            }
                                            if (file.type.startsWith('image/')) {
                                                this.image = URL.createObjectURL(file);
                                                this.fileName = ''; // Reset file name jika gambar
                                            } else {
                                                this.image = ''; // Reset image jika bukan gambar
                                                this.fileName = file.name; // Simpan nama file
                                            }
                                            this.lbl = false;
                                        }
                                    }">
                                        <x-input-label ::for="label" x-text="text" />
                                        <div
                                            class="relative flex w-full mt-1 text-center rounded-md shadow-md aspect-square">
                                            <img :src="image" :alt="text"
                                                class="absolute top-0 left-0 z-10 object-cover rounded-md size-full"
                                                x-show="image">
                                            <!-- Tampilkan Nama File Jika Bukan Gambar -->
                                            <span
                                                class="absolute text-gray-700 transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                                x-show="fileName" x-text="fileName"></span>
                                            <input type="file" :id="label"
                                                :name="'files[' + index + '][file]'" @change="imagePreview(event)"
                                                class="sr-only">
                                            <label :for="label"
                                                :class="{ 'opacity-100': (lbl), 'opacity-0': !lbl }"
                                                class="absolute top-0 left-0 z-20 flex items-center justify-center w-full h-full bg-transparent border border-black border-dashed rounded-md cursor-pointer ALIGN text-sky-500 hover:text-blue-700"
                                                x-text="text"></label>
                                            <x-action-a
                                                class="absolute z-30 p-1 cursor-pointer top-2 left-2 size-10 bg-rose-500"
                                                x-data="" @click.prevent="removeItem">
                                                <x-action-label>Hapus</x-action-label>
                                                <svg width="24px" height="24px" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                    </g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path
                                                            d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17"
                                                            stroke="#000000" stroke-width="1" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </g>
                                                </svg>
                                            </x-action-a>
                                        </div>
                                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                    </div>
                                </template>
                                <button type="button" @click="addItem"
                                    class="flex items-center justify-center w-full text-white border border-black border-dashed rounded aspect-square">
                                    <svg width="48px" height="48px" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M12 6C12.5523 6 13 6.44772 13 7V11H17C17.5523 11 18 11.4477 18 12C18 12.5523 17.5523 13 17 13H13V17C13 17.5523 12.5523 18 12 18C11.4477 18 11 17.5523 11 17V13H7C6.44772 13 6 12.5523 6 12C6 11.4477 6.44772 11 7 11H11V7C11 6.44772 11.4477 6 12 6Z"
                                                fill="#000000"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2 4.5C2 3.11929 3.11929 2 4.5 2H19.5C20.8807 2 22 3.11929 22 4.5V19.5C22 20.8807 20.8807 22 19.5 22H4.5C3.11929 22 2 20.8807 2 19.5V4.5ZM4.5 4C4.22386 4 4 4.22386 4 4.5V19.5C4 19.7761 4.22386 20 4.5 20H19.5C19.7761 20 20 19.7761 20 19.5V4.5C20 4.22386 19.7761 4 19.5 4H4.5Z"
                                                fill="#000000"></path>
                                        </g>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="sticky w-full space-y-4 md:w-1/3" x-data="{ status: 'selesai', diskon: 0 }">
                        <div class="w-full">
                            <x-input-label for="status" :value="__('status')" />
                            <x-select-input name="status" id="status" x-model="status">
                                @foreach ($status as $item)
                                    <x-select-option value="{{ $item }}"
                                        :selected="old('status') == $item">{{ $item }}
                                    </x-select-option>
                                @endforeach
                            </x-select-input>
                            <x-input-error :messages="$errors->tambahTransaksi->get('status')" class="mt-2" />
                        </div>
                        <div class="w-full" x-show="status !== 'selesai'" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <x-input-label for="selesai" :value="__('estimasi selesai')" />
                            <x-text-input id="selesai" class="block w-full mt-1" type="date" name="selesai"
                                :value="old('selesai')" autofocus autocomplete="selesai" />
                            <x-input-error :messages="$errors->tambahTransaksi->get('selesai')" class="mt-2" />
                        </div>
                        <div class="w-full">
                            <x-input-label for="diskon" :value="__('diskon(%)')" />
                            <x-text-input id="diskon" x-model="diskon" class="block w-full mt-1" type="number"
                                name="diskon" :value="old('diskon')" required autofocus autocomplete="diskon" />
                            <x-input-error :messages="$errors->tambahTransaksi->get('diskon')" class="mt-2" />
                        </div>

                        <div class="w-full">
                            <x-input-label for="platform" :value="__('Platform transaksi')" />
                            <x-select-input name="platform" id="platform">
                                @foreach ($platform as $key => $item)
                                    <x-select-option value="{{ $key }}"
                                        :selected="old('platform') == $key">{{ $key }}
                                    </x-select-option>
                                @endforeach
                            </x-select-input>
                            <x-input-error :messages="$errors->tambahTransaksi->get('platform')" class="mt-2" />
                        </div>
                        <div class="w-full">
                            <x-input-label for="payment" :value="__('metode pembayaran')" />
                            <x-select-input name="payment" id="payment">
                                <x-select-option value="cash" :selected="old('payment') == 'cash'">cash
                                </x-select-option>
                                <x-select-option value="tranfer" :selected="old('payment') == 'transfer'">transfer
                                </x-select-option>
                            </x-select-input>
                            <x-input-error :messages="$errors->tambahTransaksi->get('payment')" class="mt-2" />
                        </div>

                        <div class="">
                            <div class="flex justify-between">
                                <div class="">Jumlah Transaksi</div>
                                <div class="" x-text="(totalPrice/100)+'K'"></div>
                            </div>
                            <div class="flex justify-between pb-2 border-b-2 border-mine-200">
                                <div class="">Discount</div>
                                <div class="" x-text="(totalPrice*(diskon/100))/100+'K'"></div>
                            </div>
                            <div class="flex justify-between">
                                <div class="">Total Transaksi</div>
                                <div class="" x-text="(((100-diskon)/100)*totalPrice)/100+'K'"></div>
                                <input type="hidden" name="total" :value="((100 - diskon) / 100) * totalPrice">
                            </div>
                        </div>
                        <div class="flex justify-center w-full">
                            <x-primary-button class="mx-auto mt-4">Submit</x-primary-button>
                        </div>
                    </div>
                </form>
            </x-modal>
        @endif
    @endforeach

    <x-modal name="popup-notifikasi" class="flex items-center" :title="'Info!'" :maxWidth="'sm'"
        :show="$popup">
        <div class="">Terdapat {{ $popup }} transaksi yang harus diselesaikan hari ini!</div>
    </x-modal>

    <x-modal name="tambah-transaksi" :title="'Tambah Transaksi'" :show="$errors->tambahTransaksi->any()" :maxWidth="'7xl'">
        <form action="{{ route('transaksi.store') }}" enctype="multipart/form-data" method="post"
            class="flex flex-wrap gap-4 md:flex-nowrap" x-data="{
                items: [{
                    produk_id: 0,
                    qty: 0,
                    price: 0,
                }],

                addItem() {
                    this.items.push({
                        produk_id: 0,
                        qty: 0,
                        price: 0,
                    });
                },
                removeItem(index) {
                    this.items.splice(index, 1);
                },
                updatePrice(index) {
                    let select = document.querySelectorAll('[id=produk_id]')[index];
                    let harga = select.options[select.selectedIndex].getAttribute('data-harga');
                    this.items[index].price = harga ? parseFloat(harga) : 0;
                },
                get totalPrice() {
                    return this.items.reduce((sum, item) => sum + (item.price * item.qty), 0);
                }
            }">
            @csrf
            @foreach ($errors->all() as $message)
                <li>{{ $message }} </li>
            @endforeach


            <div class="w-full md:w-2/3">

                <div class="grid w-full grid-cols-1 gap-4 lg:grid-cols-2">
                    <div class="w-full">
                        <x-input-label for="customer" :value="__('nama customer')" />
                        <x-text-input id="customer" class="block w-full mt-1" type="text" name="customer"
                            :value="old('customer')" required autofocus autocomplete="customer" />

                        <x-input-error :messages="$errors->tambahTransaksi->get('customer')" class="mt-2" />
                    </div>
                    <div class="w-full">
                        <x-input-label for="provinsi_id" :value="__('provinsi')" />
                        <x-select-input name="provinsi_id" id="provinsi_id">
                            @foreach ($provinsi as $item)
                                <x-select-option value="{{ $item->id }}" :selected="old('provinsi_id') == $item->id">{{ $item->nama }}
                                </x-select-option>
                            @endforeach
                        </x-select-input>

                        <x-input-error :messages="$errors->tambahTransaksi->get('size')" class="mt-2" />
                    </div>
                </div>
                <div class="w-full">
                    <x-input-label for="catatan" :value="__('nama catatan')" />
                    <textarea
                        class="w-full p-1 mt-1 border rounded-md shadow-sm h-fit border-mine-200 focus:border-indigo-500 focus:ring-mine-200"
                        name="catatan" id="catatan" cols="20" rows="2">{{ old('catatan', '') }}</textarea>
                    <x-input-error :messages="$errors->tambahTransaksi->get('catatan')" class="mt-2" />
                </div>

                <div class="space-y-2">
                    <!-- Input Fields -->
                    <template x-for="(item, index) in items" :key="index">
                        <div class="flex items-end gap-2">
                            <div class="w-4/5">
                                <x-input-label for="produk_id" :value="__('Produk')" />
                                <x-select-input @change="updatePrice(index)" ::name="'produk[' + index + '][produk_id]'"
                                    x-model="item.produk_id" id="produk_id">
                                    @foreach ($stok as $item)
                                        <x-select-option :data-harga="$item->harga" value="{{ $item->produk_id }}"
                                            :selected="old('produk_id') == $item->produk_id">{{ "{$item->produk->nama} | {$item->size} " }}
                                            {{ $itm->color ?? false ? "- $itm->color" : '' }}
                                            {{ $itm->arm ?? false ? "- $itm->arm" : '' }}
                                        </x-select-option>
                                    @endforeach
                                </x-select-input>

                                <x-input-error :messages="$errors->tambahTransaksi->get('size')" class="mt-2" />
                            </div>
                            <div class="w-1/5">
                                <x-input-label for="qty" :value="__('Qty')" />
                                <x-text-input @input="updatePrice(index)" id="qty" class="block w-full mt-1"
                                    type="number" ::name="'produk[' + index + '][qty]'" x-model="item.qty" :value="old('qty')" required
                                    autofocus autocomplete="qty" />
                                <x-input-error :messages="$errors->tambahTransaksi->get('qty')" class="mt-2" />
                            </div>
                            <x-action-a class="p-1 cursor-pointer size-10 bg-rose-500" x-data=""
                                @click.prevent="removeItem">
                                <x-action-label>Hapus</x-action-label>
                                <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17"
                                            stroke="#000000" stroke-width="1" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </g>
                                </svg>
                            </x-action-a>
                        </div>
                    </template>

                    <!-- Tombol Tambah Input -->
                    <button type="button" @click="addItem"
                        class="flex justify-center w-full mt-2 text-white border border-black border-dashed rounded h-7">
                        <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M12 6C12.5523 6 13 6.44772 13 7V11H17C17.5523 11 18 11.4477 18 12C18 12.5523 17.5523 13 17 13H13V17C13 17.5523 12.5523 18 12 18C11.4477 18 11 17.5523 11 17V13H7C6.44772 13 6 12.5523 6 12C6 11.4477 6.44772 11 7 11H11V7C11 6.44772 11.4477 6 12 6Z"
                                    fill="#000000"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M2 4.5C2 3.11929 3.11929 2 4.5 2H19.5C20.8807 2 22 3.11929 22 4.5V19.5C22 20.8807 20.8807 22 19.5 22H4.5C3.11929 22 2 20.8807 2 19.5V4.5ZM4.5 4C4.22386 4 4 4.22386 4 4.5V19.5C4 19.7761 4.22386 20 4.5 20H19.5C19.7761 20 20 19.7761 20 19.5V4.5C20 4.22386 19.7761 4 19.5 4H4.5Z"
                                    fill="#000000"></path>
                            </g>
                        </svg>
                    </button>
                </div>
                <div x-data="{
                    items: [{
                        file: '',

                    }],

                    addItem() {
                        this.items.push({
                            file: '',

                        });
                    },
                    removeItem(index) {
                        this.items.splice(index, 1);
                    }
                }" class="mt-4 space-y-2">
                    <!-- Input Fields -->
                    <div class="grid items-end grid-cols-2 gap-2 md:grid-cols-4">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="relative" x-data="{
                                image: '',
                                text: 'file ' + (index + 1),
                                label: 'file' + (index + 1),
                                lbl: true,
                                fileName: '',
                                imagePreview(event) {
                                    const file = event.target.files[0];
                                    if (!file) {
                                        this.lbl = true;
                                        return;
                                    }
                                    if (file.type.startsWith('image/')) {
                                        this.image = URL.createObjectURL(file);
                                        this.fileName = ''; // Reset file name jika gambar
                                    } else {
                                        this.image = ''; // Reset image jika bukan gambar
                                        this.fileName = file.name; // Simpan nama file
                                    }
                                    this.lbl = false;
                                }
                            }">
                                <x-input-label ::for="label" x-text="text" />
                                <div class="relative flex w-full mt-1 text-center rounded-md shadow-md aspect-square">
                                    <img :src="image" :alt="text"
                                        class="absolute top-0 left-0 z-10 object-cover rounded-md size-full"
                                        x-show="image">
                                    <!-- Tampilkan Nama File Jika Bukan Gambar -->
                                    <span
                                        class="absolute text-gray-700 transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                        x-show="fileName" x-text="fileName"></span>
                                    <input type="file" :id="label" :name="'files[' + index + '][file]'"
                                        @change="imagePreview(event)" class="sr-only">
                                    <label :for="label" :class="{ 'opacity-100': (lbl), 'opacity-0': !lbl }"
                                        class="absolute top-0 left-0 z-20 flex items-center justify-center w-full h-full bg-transparent border border-black border-dashed rounded-md cursor-pointer ALIGN text-sky-500 hover:text-blue-700"
                                        x-text="text"></label>
                                    <x-action-a
                                        class="absolute z-30 p-1 cursor-pointer top-2 left-2 size-10 bg-rose-500"
                                        x-data="" @click.prevent="removeItem">
                                        <x-action-label>Hapus</x-action-label>
                                        <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17"
                                                    stroke="#000000" stroke-width="1" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </g>
                                        </svg>
                                    </x-action-a>
                                </div>
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>
                        </template>
                        <button type="button" @click="addItem"
                            class="flex items-center justify-center w-full text-white border border-black border-dashed rounded aspect-square">
                            <svg width="48px" height="48px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M12 6C12.5523 6 13 6.44772 13 7V11H17C17.5523 11 18 11.4477 18 12C18 12.5523 17.5523 13 17 13H13V17C13 17.5523 12.5523 18 12 18C11.4477 18 11 17.5523 11 17V13H7C6.44772 13 6 12.5523 6 12C6 11.4477 6.44772 11 7 11H11V7C11 6.44772 11.4477 6 12 6Z"
                                        fill="#000000"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M2 4.5C2 3.11929 3.11929 2 4.5 2H19.5C20.8807 2 22 3.11929 22 4.5V19.5C22 20.8807 20.8807 22 19.5 22H4.5C3.11929 22 2 20.8807 2 19.5V4.5ZM4.5 4C4.22386 4 4 4.22386 4 4.5V19.5C4 19.7761 4.22386 20 4.5 20H19.5C19.7761 20 20 19.7761 20 19.5V4.5C20 4.22386 19.7761 4 19.5 4H4.5Z"
                                        fill="#000000"></path>
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="sticky w-full space-y-4 md:w-1/3" x-data="{ status: 'selesai', diskon: 0 }">
                <div class="w-full">
                    <x-input-label for="status" :value="__('status')" />
                    <x-select-input name="status" id="status" x-model="status">
                        @foreach ($status as $item)
                            <x-select-option value="{{ $item }}" :selected="old('status') == $item">{{ $item }}
                            </x-select-option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->tambahTransaksi->get('status')" class="mt-2" />
                </div>
                <div class="w-full" x-show="status !== 'selesai'" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <x-input-label for="selesai" :value="__('estimasi selesai')" />
                    <x-text-input id="selesai" class="block w-full mt-1" type="date" name="selesai"
                        :value="old('selesai')" autofocus autocomplete="selesai" />
                    <x-input-error :messages="$errors->tambahTransaksi->get('selesai')" class="mt-2" />
                </div>
                <div class="w-full">
                    <x-input-label for="diskon" :value="__('diskon(%)')" />
                    <x-text-input id="diskon" x-model="diskon" class="block w-full mt-1" type="number"
                        name="diskon" :value="old('diskon')" required autofocus autocomplete="diskon" />
                    <x-input-error :messages="$errors->tambahTransaksi->get('diskon')" class="mt-2" />
                </div>

                <div class="w-full">
                    <x-input-label for="platform" :value="__('Platform transaksi')" />
                    <x-select-input name="platform" id="platform">
                        @foreach ($platform as $key => $item)
                            <x-select-option value="{{ $key }}" :selected="old('platform') == $key">{{ $key }}
                            </x-select-option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->tambahTransaksi->get('platform')" class="mt-2" />
                </div>
                <div class="w-full">
                    <x-input-label for="payment" :value="__('metode pembayaran')" />
                    <x-select-input name="payment" id="payment">
                        <x-select-option value="cash" :selected="old('payment') == 'cash'">cash
                        </x-select-option>
                        <x-select-option value="tranfer" :selected="old('payment') == 'transfer'">transfer
                        </x-select-option>
                    </x-select-input>
                    <x-input-error :messages="$errors->tambahTransaksi->get('payment')" class="mt-2" />
                </div>

                <div class="">
                    <div class="flex justify-between">
                        <div class="">Jumlah Transaksi</div>
                        <div class="" x-text="(totalPrice/100)+'K'"></div>
                    </div>
                    <div class="flex justify-between pb-2 border-b-2 border-mine-200">
                        <div class="">Discount</div>
                        <div class="" x-text="(totalPrice*(diskon/100))/100+'K'"></div>
                    </div>
                    <div class="flex justify-between">
                        <div class="">Total Transaksi</div>
                        <div class="" x-text="(((100-diskon)/100)*totalPrice)/100+'K'"></div>
                        <input type="hidden" name="total" :value="((100 - diskon) / 100) * totalPrice">
                    </div>
                </div>
                <div class="flex justify-center w-full">
                    <x-primary-button class="mx-auto mt-4">Submit</x-primary-button>
                </div>
            </div>
        </form>
    </x-modal>
</x-app-layout>
