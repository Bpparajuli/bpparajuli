@php
    $primary = setting('color_primary', '#820B5C');
    $secondary = setting('color_secondary', '#1A0262');
    $accent = setting('color_accent', '#2563EB');
@endphp

<style>
    :root {
        --brand-primary: {{ $primary }};
        --brand-secondary: {{ $secondary }};
        --brand-accent: {{ $accent }};
        --brand-primary-dark: color-mix(in oklab, {{ $primary }} 78%, black);
    }
</style>
