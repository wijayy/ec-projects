<x-app-layout title="Detail Transaksi {{ $transaksi->nomor_transaksi }}">
    <div class="flex flex-wrap gap-2 lg:flex-nowrap">
        <div class="w-full lg:w-2/3">
            <div class="grid grid-cols-1 gap-2 lg:grid-cols-2">
                <div class="w-full">
                    <x-input-label :required="false" for="customer" :value="__('nama customer')" />
                    <x-input-show>{{ $transaksi->customer }} </x-input-show>
                </div>
                <div class="w-full">
                    <x-input-label :required="false" for="provinsi" :value="__('provinsi')" />
                    <x-input-show>{{ $transaksi->provinsi->nama }} </x-input-show>
                </div>
            </div>
            <div class="w-full">
                <x-input-label :required="false" for="catatan" :value="__('catatan')" />
                <x-input-show>{{ $transaksi->catatan }} </x-input-show>
            </div>
            <div class="mt-4 space-y-2">
                <x-input-label :required="false" for="Produk" class="w-full" :value="__('Produk')" />
                @foreach ($transaksi->transaksiDetail as $itm)
                    <div class="flex items-center w-full gap-2">
                        <x-input-show class="w-full">{{ $itm->nama }} | {{ $itm->size }}
                            {{ $itm->color ? "- $itm->color" : '' }} {{ $itm->arm ? "- $itm->arm" : '' }} |
                            {{ $itm->qty }} Pcs
                        </x-input-show>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 space-y-2">
                <x-input-label :required="false" for="File" class="w-full" :value="__('File')" />
                <div class="grid items-end grid-cols-2 gap-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-6">
                    @foreach ($transaksi->transaksiFoto as $itm)
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
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
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

        <div class="w-full space-y-2 lg:w-1/3">
            <div class="flex justify-between">
                <div class="text-base">Status</div>
                <div class="text-lg">{{ $transaksi->status }} </div>
            </div>
            @if ($transaksi->status !== 'selesai')
                <div class="flex justify-between">
                    <div class="text-base">selesai</div>
                    <div class="text-lg">{{ $transaksi->selesai }} </div>
                </div>
            @endif
            <div class="flex justify-between">
                <div class="text-base">Status Pembayaran</div>
                <div class="text-lg">
                    {{ $transaksi->lunas ? 'lunas' : 'DP ' . number_format($transaksi->dp / 1000, 0, ',', '.') . 'K' }}
                </div>
            </div>
            <div class="flex justify-between">
                <div class="text-base">Plaftorm transaksi</div>
                <div class="text-lg">{{ $transaksi->platform }} </div>
            </div>
            <div class="flex justify-between">
                <div class="text-base">Jenis Pembayaran</div>
                <div class="text-lg">{{ $transaksi->payment }} </div>
            </div>
            <div class="flex justify-between">
                <div class="text-base">Diskon</div>
                <div class="text-lg">{{ $transaksi->diskon }}% </div>
            </div>
            <div class="">@php
                $total = ($transaksi->total * 100) / (100 - $transaksi->diskon);
            @endphp
                <div class="flex justify-between mt-4">
                    <div class="text-base">Jumlah Transaksi</div>
                    <div class="text-lg">{{ number_format($total / 1000, 0, ',', '.') . 'K' }} </div>
                </div>
                <div class="flex justify-between border-b-2 border-black">
                    <div class="text-base">Diskon</div>
                    <div class="text-lg">
                        {{ number_format(($total * $transaksi->diskon) / 100 / 1000, 0, ',', '.') . 'K' }} </div>
                </div>
                <div class="flex justify-between">
                    <div class="text-base">Total Transaksi</div>
                    <div class="text-lg">{{ number_format($transaksi->total / 1000, 0, ',', '.') . 'K' }} </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
