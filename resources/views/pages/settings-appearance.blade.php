<x-layouts.dashboard>

<div class="space-y-8">

<div>

<h1 class="text-3xl font-bold">

Appearance

</h1>

<p class="text-zinc-500">

Customize dashboard interface

</p>

</div>


@if(session('success'))

<div
class="rounded-2xl border border-green-200 bg-green-50 p-4 text-green-700">

{{ session('success') }}

</div>

@endif


<div
class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-8">

<form
action="{{ route('settings.appearance.update') }}"
method="POST"
class="space-y-6">

@csrf


<label class="flex items-center gap-3">

<input
type="checkbox"
name="compact_sidebar"
value="1"
{{ $settings?->compact_sidebar ? 'checked':'' }}>

<span>

Compact Sidebar

</span>

</label>


<label class="flex items-center gap-3">

<input
type="checkbox"
name="fixed_header"
value="1"
{{ $settings?->fixed_header ? 'checked':'' }}>

<span>

Fixed Header

</span>

</label>


<label class="flex items-center gap-3">

<input
type="checkbox"
name="show_animations"
value="1"
{{ $settings?->show_animations ? 'checked':'' }}>

<span>

Show Animations

</span>

</label>


<label class="flex items-center gap-3">

<input
type="checkbox"
name="show_statistics"
value="1"
{{ $settings?->show_statistics ? 'checked':'' }}>

<span>

Show Statistics Cards

</span>

</label>


<label class="flex items-center gap-3">

<input
type="checkbox"
name="show_product_chart"
value="1"
{{ $settings?->show_product_chart ? 'checked':'' }}>

<span>

Show Product Chart

</span>

</label>


<div class="flex justify-end">

<flux:button
variant="primary"
type="submit">

Save Changes

</flux:button>

</div>

</form>

</div>

</div>

</x-layouts.dashboard>