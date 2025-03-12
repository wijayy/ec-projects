<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex h-fit shadow-mine drop-shadow-md items-center px-4 py-2 bg-mine-100 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest text-nowrap hover:bg-mine-200 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
