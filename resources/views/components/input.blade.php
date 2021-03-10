@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'p-2 rounded-md shadow-sm border border-gray-300 outline-none focus:border-indigo-500 disabled:opacity-60']) !!}>
