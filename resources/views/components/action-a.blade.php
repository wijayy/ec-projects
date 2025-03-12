@php
    $classes =
        'size-7 text-black relative flex group/action justify-center items-center rounded-lg hover:scale-110 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
