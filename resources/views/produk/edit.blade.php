<x-app-layout title="Edit Produk {{ $produk->nama }}">

    <form action="{{ route('produk.update', ['produk' => $produk->slug]) }}" enctype="multipart/form-data" method="post"
        x-data='updateProduk("{{ $produk->size }}", "{{ $produk->color }}", "{{ $produk->arm }}", {!! json_encode($produk->stoks) !!})'>
        @csrf
        @method('put')
        @foreach ($errors->editProduk->all() as $produk)
            <li>{{ $item }} </li>
        @endforeach

        <div x-data='{ items: {!! json_encode(
            $produk->produkFoto->map(function ($image) {
                return [
                    'id' => $image->id,
                    'image' => asset('storage/' . $image->image),
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
        <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-2">
            <div class="w-full">
                <x-input-label for="nama" :value="__('nama produk')" />
                <x-text-input id="nama" class="block w-full mt-1" type="text" name="nama" :value="old('nama', $produk->nama)"
                    required autofocus autocomplete="nama produk" />
                <x-input-error :messages="$errors->tambahProduk->get('nama')" class="mt-2" />
            </div>
            <div class="w-full">
                <x-input-label for="deskripsi" :value="__('deskripsi')" />
                <x-text-input id="deskripsi" class="block w-full mt-1" type="text" name="deskripsi" :value="old('deskripsi', $produk->deskripsi)"
                    required autofocus autocomplete="deksripsi" />
                <x-input-error :messages="$errors->tambahProduk->get('deskripsi')" class="mt-2" />
            </div>
        </div>


        <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-3">
            <div class="w-full">
                <x-input-label for="size">Size (<span class="underline cursor-pointer underline-offset-1"
                        @click="sizeInput='S,M,L,XL,XXL,XXXL'; updateCombinations()">Baju</span> |
                    <span class="underline cursor-pointer underline-offset-1"
                        @click="sizeInput='A6,A5,A4,A3,A2,1Meter'; updateCombinations()">Sablon</span>)
                </x-input-label>
                <x-text-input id="size" x-model="sizeInput" @input="updateCombinations()" class="block w-full mt-1"
                    type="text" :value="old('size')" name="size" required autofocus autocomplete="size" />
            </div>

            <div class="w-full">
                <x-input-label for="color" :value="__('Color')" />
                <x-text-input id="color" x-model="colorInput" @input="updateCombinations()"
                    class="block w-full mt-1" type="text" :value="old('color')" name="color" autocomplete="color" />
            </div>

            <div class="gap-2">
                <div class="font-semibold">Arm</div>
                <div class="flex items-center h-8 gap-4">
                    <label class="flex items-center mb-2 space-x-2">
                        <input type="checkbox" x-model="hasShortArm" name="arm[]" value="pendek"
                            class="w-4 h-4 rounded-md text-mine-200 focus:caret-mine-100"
                            @change="toggleArm('pendek')">
                        <span class="text-sm font-semibold">Pendek</span>
                    </label>
                    <label class="flex items-center mb-2 space-x-2">
                        <input type="checkbox" x-model="hasLongArm" name="arm[]" value="panjang"
                            class="w-4 h-4 rounded-md text-mine-200 focus:caret-mine-100"
                            @change="toggleArm('panjang')">
                        <span class="text-sm font-semibold">Panjang</span>
                    </label>
                </div>
            </div>

        </div>
        <div class="grid w-full grid-cols-2 gap-4 mt-4">
            <div class="">
                <div class="flex items-center gap-2">
                    <input type="checkbox" x-model="applyStock" class="w-4 h-4 text-mine-200 focus:ring-mine-100">
                    <span class="text-sm font-semibold">Terapkan stok ke semua variasi</span>
                </div>
                <template x-if="applyStock">
                    <div class="mt-2">
                        <input type="number" x-model="stockValue" @input="applyStockToAll()" min="0"
                            class="w-full h-8 p-1 border rounded-md shadow-sm border-mine-200 focus:border-mine-200 focus:ring-mine-200 "
                            placeholder="Masukkan stok untuk semua variasi">
                    </div>
                </template>
            </div>
            <div class="">
                <div class="flex items-center gap-2">
                    <input type="checkbox" x-model="applyPrice" class="w-4 h-4 text-mine-200 focus:ring-mine-100">
                    <span class="text-sm font-semibold">Terapkan harga ke semua variasi</span>
                </div>
                <template x-if="applyPrice">
                    <div class="mt-2">
                        <input type="number" x-model="priceValue" @input="applyPriceToAll()" min="0"
                            class="w-full h-8 p-1 border rounded-md shadow-sm border-mine-200 focus:border-mine-200 focus:ring-mine-200 "
                            placeholder="Masukkan harga untuk semua variasi">
                    </div>
                </template>
            </div>

        </div>
        <div class="overflow-x-auto">
            <div class="flex flex-col w-full mt-6 min-w-[500px]">
                <div class="flex w-full gap-4 p-2 ">
                    <div class="w-1/5">Size</div>
                    <div class="w-1/5">Color</div>
                    <div class="w-1/5">Arm</div>
                    <div class="w-1/5">Stok</div>
                    <div class="w-1/5">Harga</div>
                </div>
                <template x-for="(combo, index) in combinations" :key="index">

                    <div class="flex w-full gap-4 p-2 min-w-96">
                        <div class="w-1/5"><x-text-input id="size" readonly x-model="combo.size"
                                class="block w-full mt-1" type="text" ::name="'variasi[' + index + '][size]'" :value="old('size')"
                                required autofocus autocomplete="size" /></div>
                        <div class="w-1/5"><x-text-input id="color" readonly x-model="combo.color"
                                class="block w-full mt-1" type="text" ::name="'variasi[' + index + '][color]'" :value="old('color')"
                                required autofocus autocomplete="color" /></div>
                        <div class="w-1/5"><x-text-input id="arm" readonly x-model="combo.arm"
                                class="block w-full mt-1" type="text" ::name="'variasi[' + index + '][arm]'" :value="old('arm')"
                                required autofocus autocomplete="arm" /></div>
                        <div class="w-1/5"><x-text-input id="stok" x-model="combo.stok"
                                class="block w-full mt-1" type="number" ::name="'variasi[' + index + '][stok]'" :value="old('stok')"
                                required autofocus autocomplete="stok" /></div>
                        <div class="w-1/5"><x-text-input id="harga" x-model="combo.harga"
                                class="block w-full mt-1" type="number" ::name="'variasi[' + index + '][harga]'" :value="old('harga')"
                                required autofocus autocomplete="harga" /></div>
                    </div>
                </template>
                <div class="flex w-full gap-4 p-2 min-w-96">
                    <div class="w-1/5"><x-input-error :messages="$errors->tambahProduk->get('size')" class="mt-2" /></div>
                    <div class="w-1/5"><x-input-error :messages="$errors->tambahProduk->get('color')" class="mt-2" /></div>
                    <div class="w-1/5"><x-input-error :messages="$errors->tambahProduk->get('arm')" class="mt-2" /></div>
                    <div class="w-1/5"><x-input-error :messages="$errors->tambahProduk->get('stok')" class="mt-2" /></div>
                    <div class="w-1/5"><x-input-error :messages="$errors->tambahProduk->get('harga')" class="mt-2" /></div>
                </div>
            </div>
        </div>
        <div class="flex justify-center w-full">
            <x-primary-button class="mx-auto mt-4">Submit</x-primary-button>
        </div>
    </form>

    <script>
        function updateProduk(sizeInput, colorInput, armInput, stokData) {
            // console.log(stokData);
            return {
                sizeInput: sizeInput,
                colorInput: colorInput,
                armInput: armInput,
                combinations: [],

                applyStock: false, // Untuk checkbox
                stockValue: null, // Nilai stok yang diisi di input
                applyPrice: false, // Untuk checkbox
                priceValue: null, // Nilai stok yang diisi di input

                hasShortArm: false, // Apakah ada "PENDEK"
                hasLongArm: false, // Apakah ada "PANJANG"

                init() {
                    this.updateCombinations();
                },

                toggleArm(armType) {
                    let arms = this.armInput.split(',').map(a => a.trim().toUpperCase()).filter(Boolean);

                    if (armType === "pendek") {
                        if (this.hasShortArm) {
                            // Jika checkbox pendek diaktifkan, tambahkan ke daftar
                            if (!arms.includes("PENDEK")) arms.push("PENDEK");
                        } else {
                            // Jika dinonaktifkan, hapus dari daftar
                            arms = arms.filter(a => a !== "PENDEK");
                        }
                    }

                    if (armType === "panjang") {
                        if (this.hasLongArm) {
                            if (!arms.includes("PANJANG")) arms.push("PANJANG");
                        } else {
                            arms = arms.filter(a => a !== "PANJANG");
                        }
                    }

                    // Perbarui armInput lalu perbarui kombinasi
                    this.armInput = arms.join(",");
                    this.updateCombinations();
                },

                updateCombinations() {
                    // Ambil daftar ukuran (Size) → Harus ada
                    let sizes = this.sizeInput.split(',').map(s => s.trim().toUpperCase()).filter(Boolean);
                    if (sizes.length === 0) {
                        this.combinations = []; // Kosongkan jika Size tidak ada
                        return;
                    }

                    // Ambil daftar warna (Color) → Bisa kosong
                    let colors = this.colorInput.split(',').map(c => c.trim().toUpperCase()).filter(Boolean);
                    if (colors.length === 0) colors = [''];

                    // Ambil daftar panjang lengan (Arm) → Bisa kosong
                    let arms = this.armInput.split(',').map(a => a.trim().toUpperCase()).filter(Boolean);
                    if (arms.length === 0) arms = [''];

                    // Reset status arm
                    this.hasShortArm = false;
                    this.hasLongArm = false;

                    // Buat semua kombinasi
                    this.combinations = [];
                    for (let size of sizes) {
                        for (let color of colors) {
                            for (let arm of arms) {
                                let existingStock = stokData.find(s => {
                                    console.log(
                                        `Checking: ${s.size}, ${s.color}, ${s.arm} vs ${size}, ${color}, ${arm}`
                                    );
                                    return (
                                        (s.size || '').toUpperCase() === size.toUpperCase() &&
                                        ((s.color || '').toUpperCase() === color.toUpperCase() || color ===
                                            '-') &&
                                        ((s.arm || '').toUpperCase() === arm.toUpperCase() || arm === '-')
                                    );
                                });
                                console.log("Matched stock:", existingStock);

                                // console.log(existingStock);

                                this.combinations.push({
                                    size,
                                    color: color || null, // Jika kosong, jadikan `null` agar cocok dengan database
                                    arm: arm || null, // Jika kosong, jadikan `null` agar cocok dengan database
                                    stok: existingStock ? existingStock.stok : 0, // Ambil dari DB atau default 0
                                    harga: existingStock ? existingStock.harga : 0, // Ambil dari DB atau default 0
                                    // id: existingStock ? existingStock.id : 0 // Ambil dari DB atau default 0
                                });

                                // Periksa apakah ada arm "PENDEK" atau "PANJANG"
                                if (arm === "PENDEK") this.hasShortArm = true;
                                if (arm === "PANJANG") this.hasLongArm = true;
                            }
                        }
                    }
                },

                applyStockToAll() {
                    if (this.applyStock) {
                        this.combinations.forEach(item => item.stok = this.stockValue ?? 0);
                    }
                },
                applyPriceToAll() {
                    if (this.applyPrice) {
                        this.combinations.forEach(item => item.harga = this.priceValue ?? 0);
                    }
                },
            };
        }
    </script>
</x-app-layout>
