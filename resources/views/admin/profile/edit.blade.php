<x-layouts.admin title="Profile">
    <x-admin.page-header title="Profile" subtitle="Your public identity and contact details." />

    <div class="mx-auto max-w-3xl">
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="admin-card space-y-5 p-6">
                <h3 class="font-display text-base font-bold">Identity</h3>
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-form.input name="profile_name" label="Name" :value="$values['profile_name']" />
                    <x-form.input name="profile_headline" label="Headline" :value="$values['profile_headline']" hint="A short tagline shown under your name." />
                </div>
                <x-form.input name="profile_location" label="Location" :value="$values['profile_location']" />
                <x-form.input name="profile_availability" label="Availability" :value="$values['profile_availability']" hint="e.g. Available for freelance work." />
            </div>

            <div class="admin-card space-y-5 p-6">
                <h3 class="font-display text-base font-bold">Bio</h3>
                <x-form.textarea name="profile_short_bio" label="Short bio" :value="$values['profile_short_bio']" rows="3" hint="Shown on cards and listings." />
                <x-form.textarea name="profile_bio" label="Full bio" :value="$values['profile_bio']" rows="8" hint="Basic HTML is supported." />
                <x-form.textarea name="profile_current_focus" label="Current focus" :value="$values['profile_current_focus']" rows="3" />
            </div>

            <div class="admin-card space-y-5 p-6">
                <h3 class="font-display text-base font-bold">Contact</h3>
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-form.input name="contact_email" type="email" label="Email" :value="$values['contact_email']" />
                    <x-form.input name="contact_phone" label="Phone" :value="$values['contact_phone']" />
                </div>
            </div>

            <div class="admin-card space-y-5 p-6">
                <h3 class="font-display text-base font-bold">Photo</h3>
                <x-admin.image-field name="profile_image" :current="setting('profile_image')" label="Profile photo" />

                @if (setting('profile_image'))
                    <div class="pt-2">
                        <x-form.checkbox name="remove_profile_image" label="Remove current photo" />
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-3 border-t border-ink/10 pt-5">
                <button type="submit" class="admin-btn-primary">Save</button>
                <a href="{{ route('admin.dashboard') }}" class="admin-btn-light">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.admin>
