@php
$status = ['belum diproses', 'diproses', 'selesai'];
$platform = [
'offline' => 'bg-white',
'shopee' => 'bg-[#EE4D2D]',
'tiktok' => 'bg-black text-white',
'tokopedia' => 'bg-[#42b549]',
'whatsapp' => 'bg-[#25d366]',
];
@endphp
<x-app-layout title="Edit Transaksi {{ $transaksi->nomor_transaksi }}">

    <form action="{{ route('transaksi.update', ['transaksi' => $transaksi->slug]) }}" enctype="multipart/form-data"
        method="post" class="flex flex-wrap gap-4 md:flex-nowrap"
        x-data='productManager(@json($transaksi->transaksiDetail))' x-init="init()">
        @csrf
        @method('put')
        @foreach ($errors->all() as $message)
        <li>{{ $message }} </li>
        @endforeach

        <div class="w-full md:w-2/3">

            <div class="grid w-full grid-cols-1 gap-4 lg:grid-cols-2">
                <div class="w-full">
                    <x-input-label for="customer" :value="__('nama customer')" />
                    <x-text-input id="customer" class="block w-full mt-1" type="text" name="customer"
                        :value="old('customer', $transaksi->customer)" required autofocus autocomplete="customer" />

                    <x-input-error :messages="$errors->tambahTransaksi->get('customer')" class="mt-2" />
                </div>
                <div class="w-full">
                    <x-input-label for="provinsi_id" :value="__('provinsi')" />
                    <x-select-input name="provinsi_id" id="provinsi_id">
                        @foreach ($provinsi as $item)
                        <x-select-option value="{{ $item->id }}"
                            :selected="old('provinsi_id', $transaksi->provinsi_id) == $item->id">{{ $item->nama }}
                        </x-select-option>
                        @endforeach
                    </x-select-input>

                    <x-input-error :messages="$errors->tambahTransaksi->get('size')" class="mt-2" />
                </div>
            </div>
            <div class="w-full">
                <x-input-label for="catatan" :value="__('catatan')" />
                <textarea
                    class="w-full p-1 mt-1 border rounded-md shadow-sm h-fit border-mine-200 focus:border-indigo-500 focus:ring-mine-200"
                    name="catatan" id="catatan" cols="20" rows="2">{{ old('catatan', $transaksi->catatan) }}</textarea>
                <x-input-error :messages="$errors->tambahTransaksi->get('catatan')" class="mt-2" />
            </div>

            <div class="mt-4">
                <template x-for="(item, index) in items" :key="index">
                    <div class="flex items-end justify-between gap-2">
                        <div class="grid items-center w-full grid-cols-5 gap-4">
                            @if (config('app.itr') < 1) <div class="col-span-3 lg:col-span-4">
                                <x-input-label :value="__('Produk')" />
                                <x-select-input x-model="item.productId" @change="updateTotal(index)"
                                    ::name="'produk[' + index + '][produk_id]'">
                                    <x-select-option value="" disabled>Pilih Produk</x-select-option>
                                    @foreach ($stok as $stokItem)
                                    <x-select-option data-harga="{{ $item->harga }}" value="{{ $stokItem->id }}">
                                        {{ "{$stokItem->produk->nama} | {$stokItem->size}" }}
                                        {{ $stokItem->color ? "- $stokItem->color" : '' }}
                                        {{ $stokItem->arm ? "- $stokItem->arm" : '' }}
                                    </x-select-option>
                                    @endforeach
                                </x-select-input>
                        </div>
                        @else
                        <div class="col-span-5 lg:col-span-2">
                            <x-input-label :value="__('Produk')" />
                            <x-select-input x-model="item.productId" @change="updateTotal(index)"
                                ::name="'produk[' + index + '][produk_id]'">
                                <x-select-option value="" disabled>Pilih Produk</x-select-option>
                                @foreach ($stok as $stokItem)
                                <x-select-option data-harga="{{ $item->harga }}" value="{{ $stokItem->id }}">
                                    {{ "{$stokItem->produk->nama} | {$stokItem->size}" }}
                                    {{ $stokItem->color ? "- $stokItem->color" : '' }}
                                    {{ $stokItem->arm ? "- $stokItem->arm" : '' }}
                                </x-select-option>
                                @endforeach
                            </x-select-input>
                        </div>
                        <div class="col-span-3 lg:col-span-2 ">
                            <x-input-label :required="false" for="note" :value="__('note')" />
                            <x-text-input min="1" class="w-full" @input="updateTotal(index)" id="note"
                                ::name="'produk[' + index + '][note]'" type="text" x-model="item.note" />
                            <x-input-error :messages="$errors->tambahTransaksi->get('note')" class="mt-2" />
                        </div>
                        @endif
                        <div class="col-span-2 lg:col-span-1">
                            <x-input-label :value="__('Qty')" />
                            <x-text-input min="1" class="w-full" @input="updateTotal(index)"
                                ::name="'produk[' + index + '][qty]'" type="number" x-model="item.qty" required />
                        </div>
                    </div>
                    <x-action-a class="p-1 m-1 cursor-pointer size-10 bg-rose-500" @click.prevent="removeItem(index)">
                        <x-action-label>Hapus</x-action-label>
                        <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17"
                                stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </svg>
                    </x-action-a>
            </div>
            </template>

            <button type="button" @click="addItem"
                class="flex justify-center w-full mt-2 text-white border border-black border-dashed rounded h-7">
                <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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


        <div class="mt-4" x-data='{ items: {!! json_encode(
                    $transaksi->transaksiFoto->map(function ($image) {
                        return [
                            ' id'=> $image->id,
            'image' => asset('storage/' . $image->file),
            ];
            }),
            ) !!},
            addItem() { this.items.push({ id:
            null, image: "" , file: null }); },
            removeItem(index) { this.items.splice(index, 1); } }'
            class="space-y-2 ">
            <x-input-label class="">Image</x-input-label>
            <!-- Input Fields -->
            <div class="grid items-end grid-cols-2 gap-2 sm:grid-cols-3 md:grid-cols-4 2xl:grid-cols-9 xl:grid-cols-6">
                <template x-for="(item, index) in items" :key="index">
                    <div class="relative" x-data="{
                            image: item.image,

                            text: 'image ' + (index + 1),
                            label: 'image' + (index + 1),
                            lbl: false,
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

                        <div class="relative flex w-full mt-1 text-center rounded-md shadow-md aspect-square">
                            <input type="hidden" :name="'files[' + index + '][id]'" x-model="item.id">
                            <img :src="image" :alt="text"
                                class="absolute top-0 left-0 z-10 object-cover rounded-md size-full" x-show="image">
                            <!-- Tampilkan Nama File Jika Bukan Gambar -->
                            <span
                                class="absolute text-gray-700 transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                x-show="fileName" x-text="fileName"></span>
                            <input type="file" :id="label" :name="'files[' + index + '][image]'"
                                @change="imagePreview(event)" class="sr-only">
                            <label :for="label" :class="{ 'opacity-100': (lbl), 'opacity-0': !lbl }"
                                class="absolute top-0 left-0 z-20 flex items-center justify-center w-full h-full bg-transparent border border-black border-dashed rounded-md cursor-pointer ALIGN text-sky-500 hover:text-blue-700"
                                x-text="text"></label>
                            <div
                                class="absolute top-0 right-0 z-30 flex items-center justify-center p-1 cursor-pointer size-10 ">
                                <x-action-a class="bg-rose-500" x-data="" @click.prevent="removeItem">
                                    <x-action-label>Hapus</x-action-label>
                                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
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
                        </div>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                </template>
                <button type="button" @click="addItem"
                    class="flex items-center justify-center w-full text-white border border-black border-dashed rounded aspect-square">
                    <svg width="48px" height="48px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
        <div class="sticky w-full space-y-4 md:w-1/3"
            x-data="{ status: '{{  $transaksi->status }}', diskon: {{ $transaksi->diskon }}, lunas: {{ $transaksi->lunas }} }">
            <div class="w-full">
                <x-input-label for="status" :value="__('status')" />
                <x-select-input name="status" id="status" x-model="status">
                    @foreach ($status as $item)
                    <x-select-option value="{{ $item }}" :selected="old('status', $transaksi->status) == $item">{{ $item
                        }}
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
                    value="{{ old('selesai', $transaksi->selesai?->format('Y-m-d')) }}" autofocus
                    autocomplete="selesai" />
                <x-input-error :messages="$errors->tambahTransaksi->get('selesai')" class="mt-2" />
            </div>
            @if (config('app.itr') > 1)
            <div class="w-full">
                <x-input-label for="lunas" :value="__('Status Pembayaran')" />
                <x-select-input name="lunas" id="lunas" x-model="lunas">

                    <x-select-option value="1" :selected="old('lunas', $transaksi->lunas) == 1">Lunas
                    </x-select-option>
                    <x-select-option value="0" :selected="old('lunas', $transaksi->lunas) == 0">Belum Lunas
                    </x-select-option>

                </x-select-input>
                <x-input-error :messages="$errors->tambahTransaksi->get('status')" class="mt-2" />
            </div>
            <div class="w-full" x-show="lunas == 0" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <x-input-label for="dp" :value="__('masukan DP')" />
                <x-text-input id="dp" class="block w-full mt-1" type="number" name="dp"
                    :value="old('dp', $transaksi->dp)" autofocus autocomplete="dp" />
                <x-input-error :messages="$errors->tambahTransaksi->get('dp')" class="mt-2" />
            </div>
            @endif
            <div class="w-full">
                <x-input-label for="diskon" :value="__('diskon(%)')" />
                <x-text-input id="diskon" x-model="diskon" class="block w-full mt-1" type="number" name="diskon"
                    :value="old('diskon', $transaksi->diskon)" required autofocus autocomplete="diskon" />
                <x-input-error :messages="$errors->tambahTransaksi->get('diskon')" class="mt-2" />
            </div>

            <div class="w-full">
                <x-input-label for="platform" :value="__('Platform transaksi')" />
                <x-select-input name="platform" id="platform">
                    @foreach ($platform as $key => $item)
                    <x-select-option value="{{ $key }}" :selected="old('platform', $transaksi->platform) == $key">{{
                        $key }}
                    </x-select-option>
                    @endforeach
                </x-select-input>
                <x-input-error :messages="$errors->tambahTransaksi->get('platform')" class="mt-2" />
            </div>
            <div class="w-full">
                <x-input-label for="payment" :value="__('metode pembayaran')" />
                <x-select-input name="payment" id="payment">
                    <x-select-option value="cash" :selected="old('payment', $transaksi->payment) == 'cash'">cash
                    </x-select-option>
                    <x-select-option value="transfer" :selected="old('payment', $transaksi->payment) == 'transfer'">
                        transfer
                    </x-select-option>
                </x-select-input>
                <x-input-error :messages="$errors->tambahTransaksi->get('payment')" class="mt-2" />
            </div>

            <div class="">
                <div class="flex justify-between">
                    <div class="">Jumlah Transaksi</div>
                    <div x-text="(grandTotal/1000)+'K'"></div>
                </div>
                <div class="flex justify-between pb-2 border-b-2 border-mine-200">
                    <div class="">Diskon</div>
                    <div class="" x-text="(grandTotal*(diskon/100))/1000+'K'"></div>
                </div>
                <div class="flex justify-between">
                    <div class="">Total Transaksi</div>
                    <div class="" x-text="(((100-diskon)/100)*grandTotal)/1000+'K'"></div>
                </div>
            </div>
            <div class="flex justify-center w-full">
                <x-primary-button class="mx-auto mt-4">Submit</x-primary-button>
            </div>
        </div>
    </form>

    <script>
        function productManager(existingItems) {
            return {
                products: @json($stok),
                items: existingItems.map(item => ({
                    id: item.id,
                    productId: item.stok_id,
                    note: item.note,
                    qty: item.qty,
                    price: item.harga,
                    total: item.qty * item.harga
                })),
                grandTotal: 0,

                init() {
                    console.log("Produk dari database:", this.products);
                    console.log("Item transaksi sebelum edit:", this.items);

                    this.calculateGrandTotal();
                },

                addItem() {
                    this.items.push({
                        id: null,
                        productId: '',
                        qty: 1,
                        price: 0,
                        total: 0
                    });
                },

                removeItem(index) {
                    this.items.splice(index, 1); // Hapus langsung jika bukan data lama
                    this.calculateGrandTotal();
                },

                updateTotal(index) {
                    let item = this.items[index];
                    let product = this.products.find(p => p.id == item.productId);
                    item.price = product ? product.harga : 0;
                    item.total = item.qty * item.price;
                    this.calculateGrandTotal();
                },

                calculateGrandTotal() {
                    this.grandTotal = this.items.reduce((sum, item) => sum + (!item.deleted ? item.total : 0), 0);
                }
            };
        }
    </script>






</x-app-layout>
