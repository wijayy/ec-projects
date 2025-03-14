<x-app-layout title="Semua Produk">
    <div class="flex justify-end">
        <x-primary-a href="{{ route('produk.create') }}" x-data="">Tambah
            Produk</x-primary-a>
    </div>
    <div class="w-full p-4 mt-4 space-y-4 overflow-x-auto rounded-lg shadow-mine">
        <div class="flex w-full gap-4 p-1 min-w-[700px]">
            <div class="sr-only">Header</div>
            <div class="w-10 text-center">#</div>
            <div class="w-1/4">Nama Produk</div>
            <div class="w-1/4">Deskripsi</div>
            <div class="w-full">Stok</div>
            <div class="w-1/4 text-center">Action</div>
        </div>
        @foreach ($produk as $item)
            <div class="flex w-full gap-4 p-1 min-w-[700px] rounded-lg odd:bg-white even:bg-stone-100 h-fit">
                <div class="sr-only">Content</div>
                <div class="w-10 text-center">{{ $loop->iteration }} </div>
                <div class="w-1/4">{{ $item->nama }} </div>
                <div class="w-1/4">{{ $item->deskripsi }} </div>
                <div class="flex flex-wrap w-full gap-2">
                    @foreach ($item->stoks as $itm)
                        <div
                            class="p-1 rounded h-fit shadow-mine  {{ $itm->stok < 5 ? 'bg-mine-300 text-white' : 'bg-mine-100' }}">
                            {{ $itm->size }} {{ $itm->color ? "- $itm->color" : '' }}
                            {{ $itm->arm ? "- $itm->arm" : '' }} |
                            {{ $itm->stok }} Pcs | IDR {{ number_format($itm->harga / 1000, 0, ',', '.') . 'K' }}
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-center w-1/4 gap-2">
                    <x-action-a class="bg-mine-200 " href="{{ route('produk.edit-stok', ['produk' => $item->slug]) }}"
                        x-data="">
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
                    <x-action-a href="{{ route('produk.edit', ['produk' => $item->slug]) }}" x-data=""
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
        @endforeach
    </div>
    <div class="flex justify-between w-full mt-4">{{ $produk->links() }} </div>


    <script></script>
</x-app-layout>
