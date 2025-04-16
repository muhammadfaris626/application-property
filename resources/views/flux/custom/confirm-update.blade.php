@props([
    'route'
])
<div class="mt-4">
    <div class="flex gap-2">
        <flux:button type="submit"  size="sm" variant="primary">Ubah</flux:button>
        <flux:button :href="$route" size="sm" variant="danger">Kembali</flux:button>
    </div>
</div>
