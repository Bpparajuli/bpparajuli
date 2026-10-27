<x-layouts.admin :title="$item->exists ? 'Edit user' : 'New user'">
    <x-admin.form-shell :title="$item->exists ? 'Edit user' : 'Create user'" :route="$route" :item="$item">
        <form
            method="POST"
            action="{{ $item->exists ? route($route.'.update', $item) : route($route.'.store') }}"
            enctype="multipart/form-data"
            class="space-y-6"
        >
            @csrf
            @if ($item->exists)
                @method('PUT')
            @endif

            <div class="admin-card space-y-5 p-6">
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-form.input name="name" label="Name" :value="$item->name" required />
                    <x-form.input name="email" type="email" label="Email" :value="$item->email" required />
                </div>

                <x-form.input name="job_title" label="Job title" :value="$item->job_title" />
            </div>

            <div class="admin-card space-y-5 p-6">
                <h3 class="font-display text-base font-bold">Password</h3>
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-form.input name="password" type="password" label="Password" :required="! $item->exists" hint="{{ $item->exists ? 'Leave blank to keep the current password.' : 'Minimum 10 characters.' }}" />
                    <x-form.input name="password_confirmation" type="password" label="Confirm password" :required="! $item->exists" />
                </div>
            </div>

            <div class="admin-card space-y-5 p-6">
                <h3 class="font-display text-base font-bold">Profile</h3>
                <x-admin.image-field name="avatar_file" :current="$item->avatar" label="Avatar" />
                <x-form.checkbox name="is_admin" label="Administrator" :checked="$item->is_admin" hint="Grants full access to the admin area." />
            </div>

            <x-admin.form-actions :route="$route" :item="$item" />
        </form>
    </x-admin.form-shell>
</x-layouts.admin>
