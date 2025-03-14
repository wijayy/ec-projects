@props(['value', 'required' => true])

<label {{ $attributes->merge(['class' => 'flex font-medium capitalize text-sm text-gray-700']) }}>
    {{ $value ?? $slot }} @if ($required)
        <div class="text-red-500">*</div>
    @endif
</label>
