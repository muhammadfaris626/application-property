@props([
    'id',
    'action'
])

<flux:modal.trigger name="delete-profile-{{ $id }}">
    <flux:button variant="danger" icon="trash" size="xs"></flux:button>
</flux:modal.trigger>
<flux:modal name="delete-profile-{{ $id }}" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg" class="text-center mb-3">Hapus Data ?</flux:heading>
            <flux:text class="mt-5" class="text-left">
                <p>Apakah kamu yakin ingin menghapus data ?</p>
            </flux:text>
        </div>
        <div class="flex gap-2">
            <flux:spacer />
            <flux:modal.close>
                <flux:button variant="ghost">Batal</flux:button>
            </flux:modal.close>
            <form method="POST" action="{{ $action }}">
                @csrf
                @method('DELETE')
                <flux:button type="submit" variant="danger">Hapus</flux:button>
            </form>
        </div>
    </div>
</flux:modal>
