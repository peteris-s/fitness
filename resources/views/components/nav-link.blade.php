@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-purple-500 text-sm font-medium leading-5 text-purple-700 dark:text-white focus:outline-none focus:border-purple-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-600 dark:text-gray-100 hover:text-purple-700 dark:hover:text-white hover:border-purple-200 focus:outline-none focus:text-purple-700 focus:border-purple-200 transition duration-150 ease-in-out';
@endphp

<a href="{{ $attributes->get('href') ?? '#' }}" {{ $attributes->except('href')->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
