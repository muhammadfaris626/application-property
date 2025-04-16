<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Database</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Jenis Pengeluaran</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex gap-4">
            <flux:input icon="magnifying-glass" placeholder="Pencarian..." size="sm" wire:model.live="search" />
            <flux:custom.button-create-permission :routeName="'jenis-pengeluaran'" />
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4">
        <x-table>
            <x-table-heading>
                <x-table-heading-row>
                    <x-table-heading-data>NO</x-table-heading-data>
                    <x-table-heading-data>NAMA</x-table-heading-data>
                    <x-table-heading-data></x-table-heading-data>
                </x-table-heading-row>
            </x-table-heading>
            <x-table-body>
                @foreach($fetch as $key => $value)
                    <x-table-body-row :class="$loop->last ? 'border-none' : 'border-b'">
                        <x-table-body-data :class="'py-2 w-4'">{{ $key + 1 }}</x-table-body-data>
                        <x-table-body-data>{{ $value->name }}</x-table-body-data>
                        <x-table-body-data :class="'text-right'">
                            <flux:custom.button-list-permission :id="$value->id" :routeName="'jenis-pengeluaran'" />
                        </x-table-body-data>
                    </x-table-body-row>
                @endforeach
            </x-table-body>
        </x-table>
        <flux:pagination :paginator="$fetch" />
    </div>
</app>
