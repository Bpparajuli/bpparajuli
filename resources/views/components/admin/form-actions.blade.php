@props(['route', 'item', 'label' => 'item'])

<div class="flex items-center gap-3 border-t border-ink/10 pt-5">
    <button type="submit" class="admin-btn-primary">
        Save
    </button>
    <a href="{{ route($route.'.index') }}" class="admin-btn-light">Cancel</a>
</div>
