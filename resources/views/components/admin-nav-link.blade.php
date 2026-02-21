@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'flex items-center px-4 py-3 text-white bg-indigo-600 rounded-lg shadow-sm transition-all duration-200'
        : 'flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-800 rounded-lg transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>