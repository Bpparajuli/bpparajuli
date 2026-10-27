@props([
    'name' => 'sparkles',
    'class' => 'h-5 w-5',
])

@php
    $brand = \App\Support\Icon::isBrand($name);
@endphp

{!! \App\Support\Icon::render($name, $class, $brand) !!}
