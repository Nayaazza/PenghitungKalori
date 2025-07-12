@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'inline-flex items-center px-4 py-2 text-sm font-semibold leading-5 text-orange-600 bg-orange-100 rounded-lg focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-500 rounded-lg hover:text-orange-600 hover:bg-orange-50 focus:outline-none focus:bg-orange-50 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
