@props([
    'id',
    'title'
])
<flux:modal.trigger name="read-data-{{ $id }}">
    <flux:button icon="eye" tooltip="Lihat" size="xs">{{ $id }}</flux:button>
</flux:modal.trigger>
<flux:modal name="read-data-{{ $id }}" class="max-w-[800px] w-full !important">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg" class="text-center mb-3">Menampilkan Data = {{ $id }}</flux:heading>
            {{-- <flux:heading size="lg" class="text-center mb-3">Menampilkan Data</flux:heading> --}}

            {{-- <flux:text class="mt-5">
                @foreach(json_decode($title) as $key => $value)
                    <div class="grid grid-cols-2 gap-4 py-2">
                        <div class="text-left">
                            <p>{{ $value[0] }}</p>
                        </div>
                        <div>
                            <p>{{ $value[1] }}</p>
                        </div>
                    </div>
                    <flux:separator />
                @endforeach
            </flux:text> --}}
        </div>
        <div class="flex gap-2">
            <flux:spacer />
            <flux:modal.close>
                <flux:button>Kembali</flux:button>
            </flux:modal.close>
        </div>
    </div>
</flux:modal>

