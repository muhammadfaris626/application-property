@props([
    'route'
])
<div class="mt-4">
    <div class="flex gap-2">
        <flux:button type="submit"  size="sm" variant="primary" wire:click.prevent="setAction('save')">Simpan</flux:button>
        <flux:button type="submit" wire:click.prevent="setAction('save_and_add')" size="sm" variant="filled">Simpan & Tambah lainnya</flux:button>
        <flux:button :href="$route" size="sm" variant="danger">Kembali</flux:button>
    </div>
</div>
