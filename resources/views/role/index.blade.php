<x-app-layout title="Role">
    <div class="sr-only">Users</div>
    <div class="flex items-center justify-between">
        <div class="mt-4 text-2xl font-semibold">Registered Users</div>
        <x-primary-button x-data="" @click.prevent="$dispatch('open-modal', 'tambah-user')">Tambah
            Produk</x-primary-button>
    </div>

    <div class="overflow-x-auto">
        <div class="flex gap-4 border-b-2 border-black min-w-[800px]">
            <div class="w-10 text-center">#</div>
            <div class="w-full max-w-96">Nama</div>
            <div class="w-full max-w-96">Email</div>
            <div class="w-full max-w-72">Role</div>
            <div class="w-40">Last Login</div>
            <div class="w-60">Action</div>
        </div>
        @foreach ($users as $key => $item)
            <div class="flex gap-4 py-0.5 border-b border-gray-400 min-w-[800px]">
                <div class="w-10 text-center">{{ $key + 1 }} </div>
                <div class="w-full max-w-96">{{ $item->name }} </div>
                <div class="w-full max-w-96">{{ $item->email }}</div>
                <div class="w-full max-w-72">{{ $item->role?->nama ?? '' }}</div>
                <div class="w-40">{{ $item->last_login?->diffForHumans() }}</div>
                <div class="w-60">
                    <div class="z-40 flex gap-2">
                        <x-action-a href="" x-data=""
                            @click.prevent="$dispatch('open-modal', 'edit-user-{{ $key }}')"
                            class="text-black bg-yellow-300">
                            <x-action-label>Edit User</x-action-label>
                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M11 4H7.2C6.0799 4 5.51984 4 5.09202 4.21799C4.71569 4.40974 4.40973 4.7157 4.21799 5.09202C4 5.51985 4 6.0799 4 7.2V16.8C4 17.9201 4 18.4802 4.21799 18.908C4.40973 19.2843 4.71569 19.5903 5.09202 19.782C5.51984 20 6.0799 20 7.2 20H16.8C17.9201 20 18.4802 20 18.908 19.782C19.2843 19.5903 19.5903 19.2843 19.782 18.908C20 18.4802 20 17.9201 20 16.8V12.5M15.5 5.5L18.3284 8.32843M10.7627 10.2373L17.411 3.58902C18.192 2.80797 19.4584 2.80797 20.2394 3.58902C21.0205 4.37007 21.0205 5.6364 20.2394 6.41745L13.3774 13.2794C12.6158 14.0411 12.235 14.4219 11.8012 14.7247C11.4162 14.9936 11.0009 15.2162 10.564 15.3882C10.0717 15.582 9.54378 15.6885 8.48793 15.9016L8 16L8.04745 15.6678C8.21536 14.4925 8.29932 13.9048 8.49029 13.3561C8.65975 12.8692 8.89125 12.4063 9.17906 11.9786C9.50341 11.4966 9.92319 11.0768 10.7627 10.2373Z"
                                        stroke="#000000" stroke-width="1" stroke-linecap="round"
                                        stroke-linejoin="round">
                                    </path>
                                </g>
                            </svg>
                        </x-action-a>
                        @if ($item->isNot(Auth::user()))
                            <x-action-a class="z-50 cursor-pointer bg-rose-500" x-data=""
                                @click.prevent="$dispatch('open-modal', 'hapus-user-{{ $key }}')">
                                <x-action-label>Hapus Akun</x-action-label>
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
                        @endif
                        <x-modal :show="false" :title="'Tambah User Baru'" name="edit-user-{{ $key }}">
                            <form action="{{ route('users.update', ['user' => $item->id]) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="flex gap-4">
                                    <div class="w-full">
                                        <x-input-label for="nama" :value="__('nama')" />
                                        <x-text-input id="nama" readonly class="block w-full mt-1" type="text"
                                            name="nama" :value="old('nama', $item->name)" autofocus autocomplete="nama" />
                                        <x-input-error :messages="$errors->tambahUser->get('nama')" class="mt-2" />
                                    </div>
                                    <div class="w-full">
                                        <x-input-label for="role" :value="__('role')" />
                                        <x-select-input id="role" class="text-base" name="role_id">
                                            <x-select-option value="">Pilih</x-select-option>
                                            @foreach ($role as $itm)
                                                <x-select-option :selected="$itm->id == old('role', $item->role_id)"
                                                    value="{{ $itm->id }}">{{ $itm->nama }}</x-select-option>
                                            @endforeach
                                        </x-select-input>
                                        <x-input-error :messages="$errors->tambahUser->get('role')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="flex justify-center w-full">
                                    <x-primary-button class="mx-auto mt-4">Submit</x-primary-button>
                                </div>
                            </form>
                        </x-modal>
                        <x-modal name="hapus-user-{{ $key }}" :title="'Hapus Akun ' . $item->email">
                            <form method="post" action="{{ route('users.destroy', ['user' => $item->id]) }}"
                                class="p-6">
                                @csrf
                                @method('delete')

                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ __("Yakin ingin menghapus Akun $item->email?") }}
                                </h2>

                                <div class="flex justify-end mt-6">
                                    <x-secondary-button @click="$dispatch('close')">
                                        {{ __('Batal') }}
                                    </x-secondary-button>

                                    <x-danger-button class="ms-3">
                                        {{ __('Hapus Akun') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <x-modal :show="false" :title="'Tambah User Baru'" name="tambah-user">
        <form action="{{ route('users.store') }}" method="post">
            @csrf
            {{-- @foreach ($errors->all() as $item)
                <li>{{ $item }} </li>
            @endforeach --}}
            <div class="grid grid-cols-3 gap-x-4 gap-y-2">
                <div class="w-full">
                    <x-input-label for="nama" :value="__('nama')" />
                    <x-text-input id="nama" class="block w-full mt-1" type="text" name="name"
                        :value="old('nama')" required autofocus autocomplete="nama" />
                    <x-input-error :messages="$errors->tambahUser->get('nama')" class="mt-2" />
                </div>
                <div class="w-full">
                    <x-input-label for="email" :value="__('email')" />
                    <x-text-input id="email" class="block w-full mt-1" type="email" name="email"
                        :value="old('email')" required autofocus autocomplete="email" />
                    <x-input-error :messages="$errors->tambahUser->get('email')" class="mt-2" />
                </div>
                <div class="w-full">
                    <x-input-label for="role" :value="__('role')" />
                    <x-select-input id="role" class="text-base" name="role_id">
                        <x-select-option value="">Pilih</x-select-option>
                        @foreach ($role as $item)
                            <x-select-option :selected="$item->id == old('role_id')"
                                value="{{ $item->id }}">{{ $item->nama }}</x-select-option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->tambahUser->get('role_id')" class="mt-2" />
                </div>
            </div>

            <div class="flex gap-4">
                <div class="w-full">
                    <x-input-label for="password" :value="__('password')" />
                    <x-text-input id="password" class="block w-full mt-1" type="password" name="password"
                        :value="old('password')" required autocomplete="password" />
                    <x-input-error :messages="$errors->tambahUser->get('password')" class="mt-2" />
                </div>
                <div class="w-full">
                    <x-input-label for="konfirmasi_password" :value="__('konfirmasi password')" />
                    <x-text-input id="konfirmasi_password" class="block w-full mt-1" type="password"
                        name="password.confirmation" :value="old('password')" required autocomplete="password" />
                    <x-input-error :messages="$errors->tambahUser->get('password.confirmation')" class="mt-2" />
                </div>
            </div>
            <div class="flex justify-center w-full">
                <x-primary-button class="mx-auto mt-4">Submit</x-primary-button>
            </div>
        </form>
    </x-modal>


    {{-- -------------------------------------------------------------------------------------------------------------------------------------------------------------- --}}
    <div class="sr-only">Role</div>

    <div class="flex items-center justify-between mt-4">
        <div class="mt-4 text-2xl font-semibold">Registered Role</div>
        <x-primary-button x-data="" @click.prevent="$dispatch('open-modal', 'tambah-role')">Tambah
            Role</x-primary-button>
    </div>
    <div class="">
        <div class="flex gap-4 border-b-2 border-black">
            <div class="w-10 text-center">#</div>
            <div class="w-1/4">Nama Role</div>
            <div class="w-full">Hak Akses</div>
            <div class="w-40">Jumlah User</div>
            <div class="w-32">Action</div>
        </div>
        @foreach ($role as $key => $item)
            <div class="flex items-center gap-4 py-1 border-b border-gray-400">
                <div class="w-10 text-center">{{ $key + 1 }} </div>
                <div class="w-1/4">{{ $item->nama }} </div>
                <div class="flex flex-wrap w-full gap-2">
                    @foreach ($item->permissions as $itm)
                        <div class="p-1 rounded-lg bg-mine-100">
                            {{ $itm->nama }}
                        </div>
                    @endforeach
                </div>
                <div class="w-40 text-center">{{ $item->user->count() }} </div>
                <div class="w-32">
                    <div class="z-40 flex gap-2">
                        <x-action-a href="" x-data=""
                            @click.prevent="$dispatch('open-modal', 'edit-role-{{ $key }}')"
                            class="bg-yellow-300 ">
                            <x-action-label class="">Edit Role</x-action-label>
                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M11 4H7.2C6.0799 4 5.51984 4 5.09202 4.21799C4.71569 4.40974 4.40973 4.7157 4.21799 5.09202C4 5.51985 4 6.0799 4 7.2V16.8C4 17.9201 4 18.4802 4.21799 18.908C4.40973 19.2843 4.71569 19.5903 5.09202 19.782C5.51984 20 6.0799 20 7.2 20H16.8C17.9201 20 18.4802 20 18.908 19.782C19.2843 19.5903 19.5903 19.2843 19.782 18.908C20 18.4802 20 17.9201 20 16.8V12.5M15.5 5.5L18.3284 8.32843M10.7627 10.2373L17.411 3.58902C18.192 2.80797 19.4584 2.80797 20.2394 3.58902C21.0205 4.37007 21.0205 5.6364 20.2394 6.41745L13.3774 13.2794C12.6158 14.0411 12.235 14.4219 11.8012 14.7247C11.4162 14.9936 11.0009 15.2162 10.564 15.3882C10.0717 15.582 9.54378 15.6885 8.48793 15.9016L8 16L8.04745 15.6678C8.21536 14.4925 8.29932 13.9048 8.49029 13.3561C8.65975 12.8692 8.89125 12.4063 9.17906 11.9786C9.50341 11.4966 9.92319 11.0768 10.7627 10.2373Z"
                                        stroke="#000000" stroke-width="1" stroke-linecap="round"
                                        stroke-linejoin="round">
                                    </path>
                                </g>
                            </svg>
                        </x-action-a>
                        @if ($item->isNot(Auth::user()))
                            <x-action-a class="text-white cursor-pointer bg-rose-500" x-data=""
                                @click.prevent="$dispatch('open-modal', 'hapus-role-{{ $key }}')">
                                <x-action-label>Hapus Role</x-action-label>
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
                        @endif
                        <x-modal :show="false" :title="'Edit Role ' . $item->nama" name="edit-role-{{ $key }}">
                            <form action="{{ route('role.update', ['role' => $item->slug]) }}" method="post">
                                @csrf
                                @method('put')
                                {{-- @foreach ($errors->all() as $item)
                                    <li>{{ $item }} </li>
                                @endforeach --}}
                                <div class="w-full">
                                    <x-input-label for="nama" :value="__('nama Role')" />
                                    <x-text-input id="nama" class="block w-full mt-1" type="text"
                                        name="nama" :value="old('nama', $item->nama)" required autofocus autocomplete="nama" />
                                    <x-input-error :messages="$errors->editRole->get('nama')" class="mt-2" />
                                </div>

                                <div class="mt-4 space-y-3">
                                    <div class="font-semibold ">Hak Akses</div>
                                    @php
                                        $hak = \App\Models\RolesHakAkses::where('role_id', $item->id)
                                            ->pluck('hak_akses_id')
                                            ->toArray();
                                        // dd($hak);
                                    @endphp
                                    @foreach ($hakAkses as $item)
                                        <label class="flex items-center mb-2 space-x-2">
                                            <input type="checkbox" @if (in_array($item->id, $hak)) checked @endif
                                                name="option[]" value="{{ $item->id }}"
                                                class="w-4 h-4 rounded-md text-mine-200 focus:caret-mine-100">
                                            <span class="text-sm font-semibold">{{ $item->nama }} </span>
                                        </label>
                                    @endforeach
                                    <x-input-error :messages="$errors->editRole->get('option')" class="mt-2" />
                                </div>
                                <div class="flex justify-center w-full">
                                    <x-primary-button class="mx-auto mt-4">Submit</x-primary-button>
                                </div>
                            </form>
                        </x-modal>
                        <x-modal name="hapus-role-{{ $key }}" :title="'Hapus Role ' . $item->nama">
                            <form method="post" action="{{ route('role.destroy', ['role' => $item->slug]) }}"
                                class="p-6">
                                @csrf
                                @method('delete')

                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ __("Yakin ingin menghapus Role $item->nama?") }}
                                </h2>

                                <div class="flex justify-end mt-6">
                                    <x-secondary-button @click="$dispatch('close')">
                                        {{ __('Batal') }}
                                    </x-secondary-button>

                                    <x-danger-button class="ms-3">
                                        {{ __('Hapus Role') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <x-modal :show="false" :title="'Tambah Role Baru'" name="tambah-role">
        <form action="{{ route('role.store') }}" method="post">
            @csrf
            @foreach ($errors->all() as $item)
                <li>{{ $item }} </li>
            @endforeach
            <div class="w-full">
                <x-input-label for="nama" :value="__('nama Role')" />
                <x-text-input id="nama" class="block w-full mt-1" type="text" name="nama"
                    :value="old('nama')" required autofocus autocomplete="nama" />
                <x-input-error :messages="$errors->tambahRole->get('nama')" class="mt-2" />
            </div>

            <div class="mt-4 space-y-3">
                <div class="font-semibold ">Hak Akses</div>
                @foreach ($hakAkses as $item)
                    <label class="flex items-center mb-2 space-x-2">
                        <input type="checkbox" name="option[]" value="{{ $item->id }}"
                            class="w-4 h-4 rounded-md text-mine-200 focus:caret-mine-100">
                        <span class="text-sm font-semibold">{{ $item->nama }} </span>
                    </label>
                @endforeach
            </div>
            <div class="flex justify-center w-full">
                <x-primary-button class="mx-auto mt-4">Submit</x-primary-button>
            </div>
        </form>
    </x-modal>

    <div class="sr-only">Hak Akses</div>
    <div class="mt-4 text-2xl font-semibold">Registered Hak Akses</div>
    <div class="">
        <div class="flex gap-4 border-b-2 border-black">
            <div class="w-10 text-center">#</div>
            <div class="w-1/4">Nama Hak Akses</div>
            <div class="w-full">Deskripsi</div>
        </div>
        @foreach ($hakAkses as $key => $item)
            <div class="flex gap-4 py-0.5 border-b border-gray-400">
                <div class="w-10 text-center">{{ $key + 1 }} </div>
                <div class="w-1/4">{{ $item->nama }} </div>
                <div class="w-full">{{ $item->deskripsi }} </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
