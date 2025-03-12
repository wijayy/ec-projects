@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-mine-200 p-1 border h-8 focus:border-mine-200 focus:ring-mine-200 rounded-md shadow-sm']) }}>
