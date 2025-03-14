<x-app-layout title="Update Stok {{ $produk->nama }}">
    {{-- @dd($produk->stoks) --}}
    <form action="{{ route('produk.update-stok', ['produk' => $produk->slug]) }}" method="post"
        x-data='updateStok("{{ $produk->size }}", "{{ $produk->color }}", "{{ $produk->arm }}", {!! json_encode($produk->stoks) !!})'>
        @csrf

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
                    {{-- <input type="hidden" :name="'variasi[' + index + '][id]'" x-model="combo.id"> --}}
                    <div class="flex w-full gap-4 p-2 min-w-[500px] even:bg-mine-200/15 rounded-lg">
                        <div class="w-1/5"><x-text-input id="size" readonly x-model="combo.size"
                                class="block w-full mt-1" type="text" ::name="'variasi[' + index + '][size]'" required autofocus
                                autocomplete="size" /></div>
                        <div class="w-1/5"><x-text-input id="color" readonly x-model="combo.color"
                                class="block w-full mt-1" type="text" ::name="'variasi[' + index + '][color]'" required autofocus
                                autocomplete="color" /></div>
                        <div class="w-1/5"><x-text-input id="arm" readonly x-model="combo.arm"
                                class="block w-full mt-1" type="text" ::name="'variasi[' + index + '][arm]'" required autofocus
                                autocomplete="arm" /></div>
                        <div class="w-1/5"><x-text-input id="stok" x-model="combo.stok" class="block w-full mt-1"
                                type="number" ::name="'variasi[' + index + '][stok]'" required autofocus autocomplete="stok" /></div>
                        <div class="w-1/5"><x-text-input id="harga" x-model="combo.harga" class="block w-full mt-1"
                                type="number" ::name="'variasi[' + index + '][harga]'" required autofocus autocomplete="harga" /></div>
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
        function updateStok(sizeInput, colorInput, armInput, stokData) {
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


                init() {
                    this.updateCombinations();
                },



                updateCombinations() {
                    // Ambil daftar ukuran (Size) → Harus ada
                    let sizes = this.sizeInput.split(',').map(s => s.trim().toUpperCase()).filter(Boolean);
                    if (sizes.length === 0) {
                        this.combinations = []; // Kosongkan jika Size tidak ada
                        return;
                    }
                    // Ambil daftar warna (Color) → Bisa kosong, tetapi tetap harus ada elemen dalam array
                    let colors = this.colorInput.split(',').map(c => c.trim().toUpperCase()).filter(Boolean);
                    if (colors.length === 0) colors = ['']; // Jika kosong, gunakan array kosong sebagai placeholder

                    // Ambil daftar panjang lengan (Arm) → Bisa kosong, tetapi tetap harus ada elemen dalam array
                    let arms = this.armInput.split(',').map(a => a.trim().toUpperCase()).filter(Boolean);
                    if (arms.length === 0) arms = ['']; // Jika kosong, gunakan array kosong sebagai placeholder



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
                                    harga: existingStock ? existingStock.harga : 0 // Ambil dari DB atau default 0
                                });


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
