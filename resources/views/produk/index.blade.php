<x-app-layout title="Semua Produk">
    <div class="flex justify-end">
        <x-primary-button x-data="" @click.prevent="$dispatch('open-modal', 'tambah-produk')">Tambah
            Produk</x-primary-button>
    </div>
    <div class="w-full p-4 mt-4 space-y-4 rounded-lg shadow-mine">
        <div class="flex w-full gap-4 p-1">
            <div class="sr-only">Header</div>
            <div class="w-10 text-center">#</div>
            <div class="w-1/4">Nama Produk</div>
            <div class="w-1/4">Deskripsi</div>
            <div class="w-full">Stok</div>
            <div class="w-1/4 text-center">Action</div>
        </div>
        @foreach ($produk as $item)
            <div class="flex w-full gap-4 p-1 even:bg-stone-100 h-fit">
                <div class="sr-only">Content</div>
                <div class="w-10 text-center">{{ $loop->iteration }} </div>
                <div class="w-1/4">{{ $item->nama }} </div>
                <div class="w-1/4">{{ $item->deskripsi }} </div>
                <div class="flex flex-wrap w-full gap-2">
                    @foreach ($item->stok as $itm)
                        <div
                            class="p-1 rounded h-fit shadow-mine  {{ $itm->stok < 5 ? 'bg-mine-300 text-white' : 'bg-mine-100' }}">
                            {{ $itm->size }} {{ $itm->color ? "- $itm->color" : '' }}
                            {{ $itm->arm ? "- $itm->arm" : '' }} |
                            {{ $itm->stok }} Pcs | IDR {{ number_format($itm->harga / 1000, 0, ',', '.') . 'K' }}
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-center w-1/4 gap-2">
                    <x-action-a class="bg-mine-200 " x-data=""
                        @click.prevent="$dispatch('open-modal', 'tambah-stok-{{ $loop->iteration }}')">
                        <x-action-label>Tambah Stok</x-action-label>
                        <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M6 12H18M12 6V18" stroke="#000000" stroke-width="1" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </x-action-a>
                    <x-action-a href="" x-data=""
                        @click.prevent="$dispatch('open-modal', 'edit-produk-{{ $loop->iteration }}')"
                        class="bg-yellow-300">
                        <x-action-label>Edit Produk</x-action-label>
                        <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M11 4H7.2C6.0799 4 5.51984 4 5.09202 4.21799C4.71569 4.40974 4.40973 4.7157 4.21799 5.09202C4 5.51985 4 6.0799 4 7.2V16.8C4 17.9201 4 18.4802 4.21799 18.908C4.40973 19.2843 4.71569 19.5903 5.09202 19.782C5.51984 20 6.0799 20 7.2 20H16.8C17.9201 20 18.4802 20 18.908 19.782C19.2843 19.5903 19.5903 19.2843 19.782 18.908C20 18.4802 20 17.9201 20 16.8V12.5M15.5 5.5L18.3284 8.32843M10.7627 10.2373L17.411 3.58902C18.192 2.80797 19.4584 2.80797 20.2394 3.58902C21.0205 4.37007 21.0205 5.6364 20.2394 6.41745L13.3774 13.2794C12.6158 14.0411 12.235 14.4219 11.8012 14.7247C11.4162 14.9936 11.0009 15.2162 10.564 15.3882C10.0717 15.582 9.54378 15.6885 8.48793 15.9016L8 16L8.04745 15.6678C8.21536 14.4925 8.29932 13.9048 8.49029 13.3561C8.65975 12.8692 8.89125 12.4063 9.17906 11.9786C9.50341 11.4966 9.92319 11.0768 10.7627 10.2373Z"
                                    stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                            </g>
                        </svg>
                    </x-action-a>
                    <x-action-set :delete="route('profile.destroy')"></x-action-set>
                </div>
            </div>
            <x-modal name="tambah-stok-{{ $loop->iteration }}" :title="'Update Stok pada Produk ' . $item->nama" :show="false" :maxWidth="'5xl'">
                <form action="{{ route('produk.update-stok', ['produk' => $item->slug]) }}" method="post">
                    @csrf
                    <div class="grid grid-cols-1 gap-4 mt-6 sm:grid-cols-2 xl:grid-cols-4">
                        @foreach ($item->stok as $itm)
                            <div class="p-2 border rounded-lg md:p-4 shadow-mine border-mine-200">
                                <input type="hidden" name="variasi[{{ $loop->index }}][id]'"
                                    value="{{ $itm->id }}">
                                <div class="w-full">
                                    <x-input-label for="size" :value="__('size')" />
                                    <x-text-input id="size" readonly class="block w-full mt-1" type="text"
                                        name="variasi[{{ $loop->index }}][size]'" :value="old('size', $itm->size)" required autofocus
                                        autocomplete="size" />
                                    <x-input-error :messages="$errors->tambahStok->get('size')" class="mt-2" />
                                </div>
                                <div class="w-full">
                                    <x-input-label for="color" :value="__('color')" />
                                    <x-text-input id="color" readonly class="block w-full mt-1" type="text"
                                        name="variasi[{{ $loop->index }}][color]'" :value="old('color', $itm->color)" required
                                        autofocus autocomplete="color" />
                                    <x-input-error :messages="$errors->tambahStok->get('color')" class="mt-2" />
                                </div>
                                <div class="w-full">
                                    <x-input-label for="arm" :value="__('arm length')" />
                                    <x-text-input id="arm" readonly class="block w-full mt-1" type="text"
                                        name="variasi[{{ $loop->index }}][arm]'" :value="old('arm', $itm->arm)" required autofocus
                                        autocomplete="arm" />
                                    <x-input-error :messages="$errors->tambahStok->get('arm')" class="mt-2" />
                                </div>
                                <div class="w-full">
                                    <x-input-label for="stok" :value="__('stok')" />
                                    <x-text-input id="stok" class="block w-full mt-1" type="number"
                                        name="variasi[{{ $loop->index }}][stok]'" :value="old('stok', $itm->stok)" required
                                        autofocus autocomplete="stok" />
                                    <x-input-error :messages="$errors->tambahStok->get('stok')" class="mt-2" />
                                </div>
                                <div class="w-full">
                                    <x-input-label for="harga" :value="__('harga')" />
                                    <x-text-input id="harga" class="block w-full mt-1" type="number"
                                        name="variasi[{{ $loop->index }}][harga]'" :value="old('harga', $itm->harga)" required
                                        autofocus autocomplete="harga" />
                                    <x-input-error :messages="$errors->tambahStok->get('harga')" class="mt-2" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-center w-full">
                        <x-primary-button class="mx-auto mt-4">Submit</x-primary-button>
                    </div>
                </form>
            </x-modal>
            <x-modal name="edit-produk-{{ $loop->iteration }}" :title="'Update Stok pada Produk ' . $item->nama" :show="false"
                :maxWidth="'5xl'">
                <form action="{{ route('produk.store') }}" method="post" x-data="productManager()">
                    @csrf
                    @foreach ($errors->all() as $item)
                        <li>{{ $item }} </li>
                    @endforeach
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="w-full">
                            <x-input-label for="nama" :value="__('nama produk')" />
                            <x-text-input id="nama" class="block w-full mt-1" type="text" name="nama"
                                :value="old('nama', $item->nama)" required autofocus autocomplete="nama produk" />
                            <x-input-error :messages="$errors->tambahProduk->get('nama')" class="mt-2" />
                        </div>
                        <div class="w-full">
                            <x-input-label for="deskripsi" :value="__('deskripsi')" />
                            <x-text-input id="deskripsi" class="block w-full mt-1" type="text" name="deskripsi"
                                :value="old('deskripsi', $item->deskripsi)" required autofocus autocomplete="deksripsi" />
                            <x-input-error :messages="$errors->tambahProduk->get('deskripsi')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-3">
                        <div class="w-full">
                            <x-input-label for="size" :value="__('size')" />
                            <x-text-input id="size" x-model="sizeInput" @input="updateCombinations()"
                                class="block w-full mt-1" type="text" name="size" :value="old('size')" required
                                autofocus autocomplete="size" />

                            <x-input-error :messages="$errors->tambahProduk->get('size')" class="mt-2" />
                        </div>
                        <div class="w-full">
                            <x-input-label for="color" :value="__('color')" />
                            <x-text-input id="color" x-model="colorInput" @input="updateCombinations()"
                                class="block w-full mt-1" type="text" name="color" :value="old('color')" autofocus
                                autocomplete="color" />
                            <x-input-error :messages="$errors->tambahProduk->get('color')" class="mt-2" />
                        </div>
                        <div class="w-full">
                            <x-input-label for="arm" :value="__('arm length')" />
                            <x-text-input id="arm" x-model="armInput" @input="updateCombinations()"
                                class="block w-full mt-1" type="text" name="arm" :value="old('arm')" autofocus
                                autocomplete="arm" />
                            <x-input-error :messages="$errors->tambahProduk->get('arm')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 mt-6 sm:grid-cols-2 xl:grid-cols-4">
                        <template x-for="(combo, index) in combinations" :key="index">
                            <div class="p-2 border rounded-lg md:p-4 shadow-mine border-mine-200">
                                <div class="w-full">
                                    <x-input-label for="size" :value="__('size')" />
                                    <x-text-input id="size" readonly x-model="combo.size"
                                        class="block w-full mt-1" type="text" ::name="'variasi[' + index + '][size]'" :value="old('size')"
                                        required autofocus autocomplete="size" />
                                    <x-input-error :messages="$errors->tambahProduk->get('size')" class="mt-2" />
                                </div>
                                <div class="w-full">
                                    <x-input-label for="color" :value="__('color')" />
                                    <x-text-input id="color" readonly x-model="combo.color"
                                        class="block w-full mt-1" type="text" ::name="'variasi[' + index + '][color]'" :value="old('color')"
                                        required autofocus autocomplete="color" />
                                    <x-input-error :messages="$errors->tambahProduk->get('color')" class="mt-2" />
                                </div>
                                <div class="w-full">
                                    <x-input-label for="arm" :value="__('arm length')" />
                                    <x-text-input id="arm" readonly x-model="combo.arm"
                                        class="block w-full mt-1" type="text" ::name="'variasi[' + index + '][arm]'" :value="old('arm')"
                                        required autofocus autocomplete="arm" />
                                    <x-input-error :messages="$errors->tambahProduk->get('arm')" class="mt-2" />
                                </div>
                                <div class="w-full">
                                    <x-input-label for="stok" :value="__('stok')" />
                                    <x-text-input id="stok" x-model="combo.stok" class="block w-full mt-1"
                                        type="number" ::name="'variasi[' + index + '][stok]'" :value="old('stok')" required autofocus
                                        autocomplete="stok" />
                                    <x-input-error :messages="$errors->tambahProduk->get('stok')" class="mt-2" />
                                </div>
                                <div class="w-full">
                                    <x-input-label for="harga" :value="__('harga')" />
                                    <x-text-input id="harga" x-model="combo.harga" class="block w-full mt-1"
                                        type="number" ::name="'variasi[' + index + '][harga]'" :value="old('harga')" required autofocus
                                        autocomplete="harga" />
                                    <x-input-error :messages="$errors->tambahProduk->get('harga')" class="mt-2" />
                                </div>
                            </div>
                        </template>

                    </div>
                    <div class="flex justify-center w-full">
                        <x-primary-button class="mx-auto mt-4">Submit</x-primary-button>
                    </div>
                </form>
            </x-modal>
        @endforeach
    </div>
    <x-modal name="tambah-produk" :title="'Tambah Produk'" :show="false" :maxWidth="'5xl'">
        <form action="{{ route('produk.store') }}" method="post" x-data="productManager()">
            @csrf
            @foreach ($errors->all() as $item)
                <li>{{ $item }} </li>
            @endforeach
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="w-full">
                    <x-input-label for="nama" :value="__('nama produk')" />
                    <x-text-input id="nama" class="block w-full mt-1" type="text" name="nama"
                        :value="old('nama')" required autofocus autocomplete="nama produk" />
                    <x-input-error :messages="$errors->tambahProduk->get('nama')" class="mt-2" />
                </div>
                <div class="w-full">
                    <x-input-label for="deskripsi" :value="__('deskripsi')" />
                    <x-text-input id="deskripsi" class="block w-full mt-1" type="text" name="deskripsi"
                        :value="old('deskripsi')" required autofocus autocomplete="deksripsi" />
                    <x-input-error :messages="$errors->tambahProduk->get('deskripsi')" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-3">
                <div class="w-full">
                    <x-input-label for="size" :value="__('size')" />
                    <x-text-input id="size" x-model="sizeInput" @input="updateCombinations()"
                        class="block w-full mt-1" type="text" name="size" :value="old('size')" required autofocus
                        autocomplete="size" />

                    <x-input-error :messages="$errors->tambahProduk->get('size')" class="mt-2" />
                </div>
                <div class="w-full">
                    <x-input-label for="color" :value="__('color')" />
                    <x-text-input id="color" x-model="colorInput" @input="updateCombinations()"
                        class="block w-full mt-1" type="text" name="color" :value="old('color')" autofocus
                        autocomplete="color" />
                    <x-input-error :messages="$errors->tambahProduk->get('color')" class="mt-2" />
                </div>
                <div class="w-full">
                    <x-input-label for="arm" :value="__('arm length')" />
                    <x-text-input id="arm" x-model="armInput" @input="updateCombinations()"
                        class="block w-full mt-1" type="text" name="arm" :value="old('arm')" autofocus
                        autocomplete="arm" />
                    <x-input-error :messages="$errors->tambahProduk->get('arm')" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 mt-6 sm:grid-cols-2 xl:grid-cols-4">
                <template x-for="(combo, index) in combinations" :key="index">
                    <div class="p-2 border rounded-lg md:p-4 shadow-mine border-mine-200">
                        <div class="w-full">
                            <x-input-label for="size" :value="__('size')" />
                            <x-text-input id="size" readonly x-model="combo.size" class="block w-full mt-1"
                                type="text" ::name="'variasi[' + index + '][size]'" :value="old('size')" required autofocus
                                autocomplete="size" />
                            <x-input-error :messages="$errors->tambahProduk->get('size')" class="mt-2" />
                        </div>
                        <div class="w-full">
                            <x-input-label for="color" :value="__('color')" />
                            <x-text-input id="color" readonly x-model="combo.color" class="block w-full mt-1"
                                type="text" ::name="'variasi[' + index + '][color]'" :value="old('color')" required autofocus
                                autocomplete="color" />
                            <x-input-error :messages="$errors->tambahProduk->get('color')" class="mt-2" />
                        </div>
                        <div class="w-full">
                            <x-input-label for="arm" :value="__('arm length')" />
                            <x-text-input id="arm" readonly x-model="combo.arm" class="block w-full mt-1"
                                type="text" ::name="'variasi[' + index + '][arm]'" :value="old('arm')" required autofocus
                                autocomplete="arm" />
                            <x-input-error :messages="$errors->tambahProduk->get('arm')" class="mt-2" />
                        </div>
                        <div class="w-full">
                            <x-input-label for="stok" :value="__('stok')" />
                            <x-text-input id="stok" x-model="combo.stok" class="block w-full mt-1"
                                type="number" ::name="'variasi[' + index + '][stok]'" :value="old('stok')" required autofocus
                                autocomplete="stok" />
                            <x-input-error :messages="$errors->tambahProduk->get('stok')" class="mt-2" />
                        </div>
                        <div class="w-full">
                            <x-input-label for="harga" :value="__('harga')" />
                            <x-text-input id="harga" x-model="combo.harga" class="block w-full mt-1"
                                type="number" ::name="'variasi[' + index + '][harga]'" :value="old('harga')" required autofocus
                                autocomplete="harga" />
                            <x-input-error :messages="$errors->tambahProduk->get('harga')" class="mt-2" />
                        </div>
                    </div>
                </template>

            </div>
            <div class="flex justify-center w-full">
                <x-primary-button class="mx-auto mt-4">Submit</x-primary-button>
            </div>
        </form>
    </x-modal>

    <script>
        function productManager() {
            return {
                sizeInput: '',
                colorInput: '',
                armInput: '',
                sizes: [],
                colors: [],
                arms: [],
                combinations: [],


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

                    // Buat semua kombinasi
                    this.combinations = [];
                    for (let size of sizes) {
                        for (let color of colors) {
                            for (let arm of arms) {
                                this.combinations.push({
                                    size,
                                    color,
                                    arm,
                                    stock: 0,
                                    price: 0
                                });
                            }
                        }
                    }
                }
            };
        }
    </script>
</x-app-layout>
