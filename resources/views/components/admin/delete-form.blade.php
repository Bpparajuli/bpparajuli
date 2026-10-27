@props(['route', 'item', 'label' => 'item', 'message' => null])

<form
    method="POST"
    action="{{ route($route.'.destroy', $item) }}"
    class="inline"
    onsubmit="return confirm('{{ $message ?? 'Delete this '.$label.'? This cannot be undone.' }}')"
>
    @csrf
    @method('DELETE')
    <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-medium text-red-600 transition hover:text-red-700" aria-label="Delete {{ $label }}">
        <x-icon name="trash" class="h-3.5 w-3.5" />
        Delete
    </button>
</form>
