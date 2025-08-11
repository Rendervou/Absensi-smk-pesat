@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-4 text-blue-600 p-3 rounded hover:bg-blue-500/30 transition ease-in-out duration-150 bg-blue-500/20'
            : 'flex items-center gap-4 text-gray-700 p-3 rounded hover:bg-gray-100 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
