<a
    {{ $attributes->merge(['class' => 'inline-flex shadow-mine h-fit drop-shadow-md items-center px-4 py-2 bg-mine-100 border border-transparent cursor-pointer rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-mine-200 hover:text-white transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
