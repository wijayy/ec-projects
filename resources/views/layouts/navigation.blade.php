<div class="w-full">
    <div class="w-full p-2 text-xl bg-white rounded-lg">
        <div class="">
            <div class="text-md lg:text-xl font-comfortaa">{{ $title }}</div>
            @if (session()->has('success'))
                <div class="text-sm capitalize">{{ session('success') }}</div>
            @endif
            @if (session()->has('error'))
                <div class="text-sm capitalize text-rose-500">{{ session('error') }}</div>
            @endif
        </div>
    </div>
</div>
